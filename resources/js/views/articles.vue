<template>
    <div>

        <form @submit.prevent="addArticle" class="mt-2">
            <input type="hidden" name="_token" :value="csrf">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="enter title" v-model="article.title">
            </div>
            <div class="form-group">
                <textarea class="form-control" placeholder="enter description" v-model="article.body"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block" v-if="edit">Update Article</button>
            <button type="submit" class="btn btn-primary btn-block" v-else>Create Article</button>
        </form>

        <div class="card mt-3" v-for="article in articles.data" v-bind:key="article.id">
            <div class="card-body">
                <h2>{{article.title}}</h2>
                <p>{{article.body}}</p>
                <button type="button" class="btn btn-info btn-block mb-1" v-on:click="editArticle(article)">EDIT</button>
                <button type="button" class="btn btn-danger btn-block" v-on:click="deleteArticle(article.id)">DELETE</button>
            </div>
        </div>

        <!-- pagination -->
            <nav aria-label="Page navigation example" >
                <ul class="pagination justify-content-center mt-2">
                    <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page}]"><a class="page-link"  href="" v-on:click="fatchArticles(pagination.prev_page)">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">{{pagination.current}} of {{pagination.total}}</a></li>
                    <li class="page-item" v-bind:class="[{disabled: !pagination.next_page}]"><a class="page-link" href="#" v-on:click="fatchArticles(pagination.next_page)">Next</a></li>
                </ul>
            </nav>

        

    </div>
</template>

<script>
    const axios = require('axios');
    export default {
        data() {
            return{
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                articles: [],
                article: {
                    id: '',
                    title: '',
                    body: '' 
                },
                pagination: '',
                edit: false
            }
        },

        created(){
            this.fatchArticles();
        },

        methods: {
            fatchArticles: function(url){
                this.edit = false;
                url = url || '/api/index';
                axios.get(url)
                .then( (response) => {
                   this.articles = response.data;
                   this.pagination = this.paginatio_info();
                })
                .catch(function (error) {
                    // handle error
                    // console.log(error);
                    alert(error);
                })
                .then(function () {
                    // always executed
                    console.log("Finished");
                });
            },

            paginatio_info: function(){
                return {
                    next_page : this.articles.links.next,
                    prev_page : this.articles.links.prev,
                    current : this.articles.meta.current_page,
                    total : this.articles.meta.last_page
                }
            },
            addArticle: function(){
                if(this.edit === false){
                    axios.post('/api/article/create', {
                    title: this.article.title,
                    body: this.article.body
                    })
                    .then( (response) => {
                        this.fatchArticles();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }else{
                    axios.put('/api/article/edit',{
                        id: this.article.id,
                        title: this.article.title,
                        body: this.article.body
                    })
                    .then( (response) => {
                        this.fatchArticles();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
                
            },

            deleteArticle: function(article_id){
                 axios.post('/api/delete/'+article_id,{_method: 'delete'})
                 .then( (response) => {
                      this.fatchArticles();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            editArticle: function(article) {
                this.edit = true,
                this.article.id = article.id;
                this.article.title = article.title;
                this.article.body = article.body;
            }
        }
    }
</script>