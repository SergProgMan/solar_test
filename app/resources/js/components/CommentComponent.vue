<template>
    <div>
        <div class="card mt-1 p-1 text-dark" :style="offset">
            <div>
                {{this.comment.content}}
            </div>
            <div class="list-inline">
                <a class="mx-3" href="#" v-on:click.prevent="toggleReply()">Reply</a>
                <a class="mx-3" href="#" v-on:click.prevent="toggleEdit()">Edit</a>
                <a class="mx-3" href="#" v-on:click.prevent="$emit('remove')">Del</a>
            </div>

        </div>
        <div class="input-group"  v-show="activeEdit" >
            <textarea
                class="form-control"
                rows="1"
                v-model="data.content"
                @keydown.enter="edit"></textarea>
            <span class="input-group-btn">
                <button class="btn btn-success" v-on:click="update">Edit</button>
            </span>
        </div>

        <div class="input-group"  v-show="activeReply" >
            <textarea
                class="form-control"
                rows="1"
                v-model="data.content_reply"
                @keydown.enter="reply"></textarea>
            <span class="input-group-btn">
                <button class="btn btn-success" v-on:click="reply">Reply</button>
            </span>
        </div>

        <template  v-if="comments">
            <comment-component
                v-for="(childComment, index) in comments"
                :key="childComment.id"
                :comment="childComment"
                :depth="depth + 1"
                v-on:remove="remove(index)"
            ></comment-component>
        </template>
    </div>



</template>

<script>
    export default {
        props: {
            comment : {type: Object, required: true},
            depth : {type: Number, default: 0},
        },
        data(){
            return{
                comments: this.comment.children_comments,
                activeEdit: false,
                activeReply: false,
                data: {
                    content: this.comment.content,
                    content_reply: '',
                }
            }
        },
        computed: {
            offset() {
                return {
                    'margin-left': (this.depth * 20) + 'px',
                };
            },
        },
        methods: {
            remove(index){
                axios.delete(`api/comment/${this.comments[index].id}`)
                    .then(() => {
                        this.comments.splice(index, 1);
                    })
                    .catch(response => {
                        alert(response.message);
                    });
            },
            toggleReply() {
                this.activeReply = !this.activeReply;
                this.activeEdit = false;
            },
            toggleEdit() {
                this.activeEdit = !this.activeEdit;
                this.activeReply = false;
            },
            update(){
                axios.put(`api/comment/${this.comment.id}`, {
                    'id': this.comment.id,
                    'content': this.data.content,
                })
                    .then((response) => {
                        this.comment.content = this.data.content;
                        this.toggleEdit();
                    })
                    .catch(response => {
                        alert(response.message);
                    });
            },
            reply(){
                axios.post(`api/comment`, {
                    'content': this.data.content_reply,
                    'parent_id': this.comment.id,
                })
                    .then((response) => {
                        if(!this.comments){
                            this.comments = [];
                        }

                        this.comments.push(response.data);

                        this.toggleReply();
                        this.data.content_reply="";
                    })
                    .catch(response => {
                        alert(response.message);
                    });
            }
        }
    }
</script>
