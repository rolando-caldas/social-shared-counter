<template>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Social Share Counter</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsApplication"
                    aria-controls="navbarsApplication" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsApplication">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a v-on:click="updateAllLink" class="nav-link">Actualizar todo</a>
                    </li>
                </ul>
            </div>
        </nav>
        <aside class="container">
            <form v-on:submit="addShare">
                    <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-rocket"></span></div>
                            <input type="url" class="form-control" id="url"
                                   placeholder="Add new url" v-model="shareToAdd.url">
                    </div>
                        <div class="input-group">
                            <button type="submit" class="btn btn-dark"><span class="fa fa-send"></span> Submit</button>
                        </div>
            </form>
        </aside>
        <main class="container">
            <ul>
                <li v-for="share in shares">
                    <span class="url">
                        {{ share.url }}
                        <a v-on:click="removeShare(share.id)" class="remove"><i class="fa fa-trash"></i></a>
                        <a v-on:click="updateShare(share.id)" class="updater"><i class="fa fa-refresh"></i></a>
                    </span>
                    <span class="social-network">
                        <span v-for="network in share.socialNetwork">
                            <i :class="networkClass(network.name)"></i> {{network.counter}}
                        </span>
                    </span>
                </li>
            </ul>
        </main>
        <footer class="footer">
            <div class="container">
                <span class="text-muted">Place sticky footer content here.</span>
            </div>
        </footer>
    </div>
</template>

<script>
  export default {
    name: 'app',
    data () {
      return {
        api: 'http://localhost:8081/',
        shares: [],
        shareToAdd: {
          id: null,
          url: null
        }
      }
    },
    methods: {
      addShare (e) {
        e.preventDefault()
        this.$http.post(this.api + 'shares', this.shareToAdd)
          .then(function (response) {
            this.getShareAndPushToList(this.shareToAdd.id)
            // this.updateShare(this.shareToAdd.id)
            this.resetShareToAdd()
          })
      },
      getShareAndPushToList (shareId) {
        this.$http.get(this.api + 'shares/' + shareId, {})
          .then(function (response) {
            this.shares.push(response.body)
          })
      },
      removeShare (shareId) {
        this.$http.delete(this.api + 'shares/' + shareId, {})
          .then(function (response) {
            this.fetchShares()
          })
      },
      updateShare (shareId) {
        console.log(shareId)
        this.$http.put(this.api + 'shares/' + shareId, {})
          .then(function (response) {
            this.fetchShares()
          })
      },
      resetShareToAdd () {
        this.shareToAdd.url = null
        this.setShareId()
      },
      setShareId () {
        this.$http.get(this.api + 'generate/uuid')
          .then(function (response) {
            this.shareToAdd.id = response.body.uuid
          })
      },
      updateAllLink (e) {
        e.preventDefault()
        this.updateAll()
      },
      updateAll () {
        this.$http.put(this.api + 'shares', {})
          .then(function (response) {
            this.fetchShares()
          })
      },
      fetchShares () {
        this.$http.get(this.api + 'shares')
          .then(function (response) {
            this.shares = response.body
          })
      },
      networkClass (network) {
        return 'social-network fa fa-' + network.charAt(0).toLowerCase() + network.slice(1)
      }
    },
    created: function () {
      this.setShareId()
      this.fetchShares()
    }
  }
</script>

<style>

    .input-group {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    #navbarsApplication li.nav-item a {
        cursor: pointer;
        padding: 10px;
    }

    main {
        margin-bottom: 69px;
        margin-top: 0;
    }

    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 60px; /* Set the fixed height of the footer here */
        line-height: 60px; /* Vertically center the text there */
        background-color: #f5f5f5;
    }

    main ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    main ul li {
        background: #f4f4f4;
        margin: 10px;
        padding: 10px;
    }

    main ul li span.url {
        display: block;
    }

    main ul li span.url .updater,
    main ul li span.url .remove {
        cursor: pointer;
        float: right;
        margin: 0 10px;
    }

    main ul li span.social-network {
        display: block;
        text-align: center;
    }

    form {
        display: block;
    }

    form div {
        display: block;
    }

    form div .btn {
        border-radius: 0;
        width: 100%;
    }

    #url {
        border-radius: 0;
    }

    @media all and (min-width: 768px) {
        form {
            display: grid;
            grid-template-columns: 75% 25%;
        }

        form div .btn {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }
    }

</style>
