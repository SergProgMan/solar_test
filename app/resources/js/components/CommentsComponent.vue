<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Abstract Post</h1>
                    </div>
                    <div class="input-group">
                        <textarea
                            class="form-control"
                            rows="1"
                            v-model="data.content"
                            @keydown.enter="create"
                            autofocus></textarea>
                        <span class="input-group-btn">
                            <button
                                class="btn btn-success"
                                @click="create">Add</button>
                        </span>
                    </div>
                </div>

                <comment-component
                    v-for="(comment, index) in comments"
                    :key="comment.id"
                    :comment="comment"
                    v-on:remove="remove(index)"
                ></comment-component>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                comments: [],
                data: {
                    content: ''
                },
            }
        },
        mounted(){
            this.loadComments();
        },
        methods: {
            loadComments(){
                axios.get('api/comment')
                    .then(response => {
                        this.comments = response.data;
                    })
                    .catch(response => {
                        alert(response.message)
                    });
            },

            remove(index){
                axios.delete(`api/comment/${this.comments[index].id}`)
                    .then(() => {
                        this.comments.splice(index, 1);
                    })
                    .catch(response => {
                        alert(response.message);
                    });
            },
            create(){
                axios.post(`api/comment`, {
                    'content': this.data.content,
                    'parent_id': null,
                })
                    .then((response) => {
                        if(!this.comments){
                            this.comments = [];
                        }

                        this.comments.push(response.data);

                        this.data.content="";
                    })
                    .catch(response => {
                        alert(response.message);
                    });
            }

        }

    }
</script>
