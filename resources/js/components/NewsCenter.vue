<template>
   <div id="news" class="col-md-12 pr-2">
       <div class="pt-3 col-md-12 row" id="news-header">
           <div class="mr-auto">
               <h2>News Center</h2>
           </div>
           <div class="ml-auto pt-3 pr-5 row">
              <span class="text-primary mr-2" @click="openModal('#addNews')">Compose</span> <i class="fa fa-envelope-open fa-2x mr-5" @click="openModal('#addNews')"></i>
               <h5 class="text-primary">{{ news.length }} Posts</h5>
           </div>
       </div>

       <div id="news-body" class=" card-deck py-3 ">

           <div class="col-md-4 col-sm-12 p-0 mb-2" v-for="post in news" :key="post.id">
              <div class="card h-100 p-0" >
                  <div class="card-body " data-aos="fade-up"
                       data-aos-offset="200"
                       data-aos-delay="25"
                       data-aos-duration="1000"
                       data-aos-easing="ease-in-out"
                  >
                      <h3 class="card-title ">
                              {{ post.title.slice(0, 36) }} {{  (post.title.length > 36)  ? '...' : '' }}

                      </h3>
                      <p class="card-text">
                          {{ post.info.slice(0,170) }}
                          <span v-if="post.info.length > 170">...</span>

                          <span class="float-right font-italic text-muted">
                              &#8212; {{ post.created_at }}
                          </span>
                      </p>
                  </div>
                  <div class="card-footer">
                      <a href="" @click="viewPost(post.title , post.id)" >Read More ....</a>

                      <span class="float-right">
                               <i class="fas fa-pencil-alt mr-1" @click="editNewsPost(post)"></i>
                               <i class="ml-1 far fa-trash-alt" @click="deleteNewsPost(post.id)"></i>
                           </span>
                  </div>
              </div>
           </div>

       </div>


<!--       modal add news-->
       <div class="modal fade" id="addNews" tabindex="-1" role="dialog" aria-labelledby="addNews" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title ml-2" id="addNewsTitle">ADD NEWS POST</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <form class="p-2" @submit.prevent="addPost">
                           <div class="form-row">
                               <div class="form-group  col-md-12">
                                   <label for="newstitle">News Title</label>
                                   <input type="text" class="form-control" v-model="newspost.title" id="newstitle" placeholder="Enter News Title Here ....">
                               </div>
                           </div>
                           <div class="form-row">
                               <div class="form-group col-md-12">
                                   <label for="info">News Information</label>
                                   <textarea type="text" v-model="newspost.info" rows="8" class="form-control" id="info" placeholder="Put News here ......"></textarea>
                               </div>
                           </div>
                           <button type="submit" class="btn btn-primary float-right">POST</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
<!--       end modal add news-->

<!--       modal edit news-->
       <div class="modal fade" id="editNews" tabindex="-1" role="dialog" aria-labelledby="editNews" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title ml-2" id="editNewsTitle">EDIT NEWS POST</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <form class="p-2" @submit.prevent="updatePost">
                           <div class="form-row">
                               <div class="form-group  col-md-12">
                                   <label for="newstitle">News Title</label>
                                   <input type="text" class="form-control" v-model="newspost.title" id="edit_newstitle" placeholder="Enter News Title Here ....">
                               </div>
                           </div>
                           <div class="form-row">
                               <div class="form-group col-md-12">
                                   <label for="info">News Information</label>
                                   <textarea type="text" v-model="newspost.info" rows="8" class="form-control" id="edit_info" placeholder="Put News here ......"></textarea>
                               </div>
                           </div>
                           <button type="submit" class="btn btn-primary float-right">UPDATE</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
<!--       end modal edit news-->


<!--       PAGINATION-->
       <nav aria-label="...">
           <ul class="pagination">
               <li :class="{ 'disabled' : !pagination.prev_url }" class="page-item">
                   <a class="page-link" href="" @click.prevent="fetchData(pagination.prev_url)">Prev</a>
               </li>
               <li class="page-item disabled" >
                  <span class="page-link text-dark">
                   Page {{ pagination.current_page }} of {{ pagination.last_page }}
                  </span>
               </li>
               <li class="page-item" :class="{ 'disabled' : !pagination.next_url }">
                   <a class="page-link" href="" @click.prevent="fetchData(pagination.next_url)">Next</a>
               </li>
           </ul>
       </nav>
   </div>
</template>

<script>

    export default {
        name: 'NewsCenter',
        data(){
            return{
                news:[] ,
                newspost: {
                    id : '',
                    title: '',
                    info : '',
                },
                pagination: {}

            }
        },
        methods:{
            viewPost(title,id){
               let postTitle = title.toLowerCase().replace(/ /g , "-");
                this.$router.push({ name : 'singlepost' , params : { postTitle,id }});
            }
            ,
            openModal(name){
                this.resetNews();
                $(name).modal('show');
            },
            resetNews(){
                this.newspost.id = ''
                this.newspost.title = ''
                this.newspost.info = ''
            },
            editNewsPost(post){
              this.openModal('#editNews')
                this.newspost.id = post.id
                this.newspost.title = post.title
                this.newspost.info = post.info
            },
            updatePost(){
               if(this.newspost.title != '' && this.newspost.info != '' && this.newspost.id != ''){
                   axios.post('/api/update-news' , this.newspost )
                       .then(response =>{
                           $('#editNews').modal('hide');
                           $('body').removeClass('modal-open');
                           $('.modal-backdrop').remove();

                           this.fetchData();
                       })
                       .catch(err => {

                       })
               }else{
                   alert("NO EMPTY UPDATES!")
               }
            },
            addPost(){
                if(this.newspost.title != '' && this.newspost.info != ''){
                    axios.post('/api/newspost' ,  this.newspost )
                        .then(response =>{
                            $('#addNews').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();

                            this.fetchData();

                        })
                        .catch(err => {

                        })
                }else{
                    alert("NO EMPTY POSTS!")
                }
            },
            fetchData(posts_url){
                    let news_url = posts_url || '/api/newsposts';
                    // let vm = this;
                    axios.get(news_url)
                    .then(response => {
                        this.news = response.data.data;
                        this.makePagination(response.data.meta , response.data.links)
                    })
                    .catch(err => {

                    })

            },
            makePagination(meta , links){
                this.pagination  = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    first_url : links.first,
                    last_url : links.last,
                    next_url : links.next,
                    prev_url : links.prev,
                }
            },
            deleteNewsPost(id){
                Swal.fire({
                    title: 'Delete Message?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                        if (result.value) {
                            axios.delete('/api/delete-news/'+ id)
                                .then(response => {
                                    this.fetchData();
                                })
                                .catch(err => {

                                })
                        }
                })
            }
        },
        computed:{
                   },
        mounted() {
            this.fetchData()
        }

    }


</script>

<style>
    #news{
        width: 99% !important;
        box-sizing: border-box;
    }
   #news-header{
       height: 64px;
       background: white;
       border-bottom: rgba(1,1,1,.6) 2px solid;
   }

    #news-body{
        background: white;
        width: 100%;
    }


</style>
