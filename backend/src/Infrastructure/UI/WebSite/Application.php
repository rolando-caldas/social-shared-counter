<?php

namespace App\Infrastructure\UI\WebSite;

use App\Application\CommandBus;
use App\Application\Share\Command\ShareRemoveCommand;
use App\Application\Share\Command\ShareRemoveCommandHandler;
use App\Application\Share\Command\ShareUpdateAllCommand;
use App\Application\Share\Command\ShareUpdateAllCommandHandler;
use App\Application\Share\Command\ShareRegisterCommand;
use App\Application\Share\Command\ShareRegisterCommandHandler;
use App\Application\Share\Command\ShareUpdateItemCommand;
use App\Application\Share\Command\ShareUpdateItemCommandHandler;
use App\Application\Share\Query\ShareInfoQuery;
use App\Application\Share\Query\ShareInfoQueryHandler;
use App\Application\Share\Query\ShareListQuery;
use App\Application\Share\Query\ShareListQueryHandler;
use App\Application\NextIdentityQuery;
use App\Application\NextIdentityQueryHandler;
use App\Application\QueryBus;
use App\Domain\Entity\EntityIdFactory;
use App\Infrastructure\Application\DoctrineSession;
use App\Infrastructure\Persistence\Doctrine\EntityManagerFactory;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class Application
{
    private $app = null;

    public function __construct()
    {
        $this->app = new \Silex\Application();
        $this->app['debug'] = true;

        $this->injectProviders();
        $this->injectPersistence();
        $this->injectRepositories();
        $this->injectFactories();
        $this->injectCommandHandlers();
        $this->injectQueryHandlers();
        $this->routing();
    }

    private function injectProviders()
    {
        $this->app->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/../../../../database/db.sqlite',
            ),
        ));
    }

    private function injectPersistence()
    {
        $this->app['em'] = function (\Silex\Application $app) {
            return (new EntityManagerFactory())->build($app['db']);
        };

        $this->app['transactional_session'] = function (\Silex\Application $app) {
            return new DoctrineSession($app['em']);
        };

    }

    private function injectRepositories()
    {
        $this->app['share_repository'] = function (\Silex\Application $app) {
            return $app['em']->getRepository('App\Domain\Entity\Share\Share');
        };
    }

    private function injectFactories()
    {
        $this->app['factory_entityId'] = new EntityIdFactory();
    }

    private function injectCommandHandlers()
    {
        $this->app['command_bus'] = function (\Silex\Application $app) {
            return (new CommandBus($app['transactional_session']))
                ->addHandler(ShareRegisterCommand::class,
                    new ShareRegisterCommandHandler(
                        $app['factory_entityId'],
                        $app['share_repository']),
                    true)
                ->addHandler(ShareUpdateAllCommand::class,
                    new ShareUpdateAllCommandHandler(
                        $app['factory_entityId'],
                        $app['share_repository']),
                    true)
                ->addHandler(ShareRemoveCommand::class,
                    new ShareRemoveCommandHandler(
                        $app['factory_entityId'],
                        $app['share_repository']),
                    true)
                ->addHandler(ShareUpdateItemCommand::class,
                    new ShareUpdateItemCommandHandler(
                        $app['factory_entityId'],
                        $app['share_repository']),
                    true)
            ;
        };
    }

    private function injectQueryHandlers()
    {
        $this->app['query_bus'] = function (\Silex\Application $app) {
            return (new QueryBus($app['transactional_session']))
                ->addHandler(NextIdentityQuery::class,
                    new NextIdentityQueryHandler(
                        $app['factory_entityId']),
                    true)
                ->addHandler(ShareListQuery::class,
                    new ShareListQueryHandler(
                        $app['share_repository']),
                    true)
                ->addHandler(ShareInfoQuery::class,
                    new ShareInfoQueryHandler(
                        $app['factory_entityId'],
                        $app['share_repository']),
                    true)
                ;
        };
    }

    private function routing()
    {
        $this->app->get('/', function (\Silex\Application $app) {
            return $app->json("Silence is beauty");
        })->bind('home');

        $this->app->get('/generate/uuid', function (\Silex\Application $app) {
            $queryResult = $app['query_bus']->handle(new NextIdentityQuery());

            return $app->json($queryResult, 200);
        })->bind('generateUuid');

        $this->routingShares();
    }

    private function routingShares()
    {
        $this->app->get('/shares', function (\Silex\Application $app) {
            return $app->json($app['query_bus']->handle(new ShareListQuery(
                (new \DateTimeImmutable())->format('Y-m-d'))
            ), 200);
        })->bind('sharers');

        $this->app->post('/shares', function (\Silex\Application $app, Request $request) {
            $response = Response::generateSuccessResponse(201, null);
            try {
                $data = json_decode($request->getContent());
                $app['command_bus']->handle(new ShareRegisterCommand($data->id, $data->url));
            } catch (\Exception $e) {
                $response = Response::generateExceptionResponse(400, $e);
            }
            return $app->json($response->response(), $response->code());
        })->bind('sharerRegister');

        $this->app->put('/shares', function (\Silex\Application $app) {
            $response = Response::generateSuccessResponse(201, null);
            try {
                $app['command_bus']->handle(new ShareUpdateAllCommand(
                    (new \DateTimeImmutable())->format('Y-m-d')
                ));
            } catch (\Exception $e) {
                $response = Response::generateExceptionResponse(400, $e);
            }
            return $app->json($response->response(), $response->code());
        })->bind('sharerCounterUpdateAll');

        $this->app->get('/shares/{id}', function (\Silex\Application $app, $id) {
            return $app->json($app['query_bus']->handle(new ShareInfoQuery($id)), 200);
        })->bind('sharerInfo');

        $this->app->put('/shares/{id}', function (\Silex\Application $app, $id) {
            $response = Response::generateSuccessResponse(201, null);
            try {
                $app['command_bus']->handle(new ShareUpdateItemCommand(
                    $id,
                    (new \DateTimeImmutable())->format('Y-m-d')
                ));
            } catch (\Exception $e) {
                $response = Response::generateExceptionResponse(400, $e);
            }
            return $app->json($response->response(), $response->code());
        })->bind('sharerCounterUpdate');


        $this->app->delete('/shares/{id}', function (\Silex\Application $app, $id) {
            return $app->json($app['command_bus']->handle(new ShareRemoveCommand($id)), 201);
        })->bind('sharerRemove');
    }

    public function entityManager()
    {
        return $this->app['em'];
    }
    public function run()
    {
        Request::enableHttpMethodParameterOverride();
        $this->app->run();
    }
}