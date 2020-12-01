<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card ">
                <form class="cart-body m-3" v-if="izmena" @submit.prevent="update">
                    <div class="card-title">
                       <input type="text" class="form-control form-contol-lg" v-model="title">
                    </div>
                    <hr>
                    <div class="media ">
                        <div class="media-body">
                            <div class="form-group">
                                <textarea name="" v-model="body" rows="10" class="form-control" required></textarea>
                            </div>
                            <button type="submit"   class="btn btn-primary" :disabled="isInvalid">Izmena</button>
                            <button @click = "cancel"  class="btn btn-danger" >Odustani</button>
                       </div>
                    </div>
                </form>
                <div class="cart-body m-3" v-else>
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{title}}</h1>
                            <div class="ml-auto">
                                <a href="/questions" class="btn btn-outline-primary">Back to all questions</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="media ">
                        <vote :model="question" name="question" ></vote>
                        <div class="media-body">
                            <div v-html="bodyHtml"></div>
                           <div class="row">
                               <div class="col-4">
                                   <div class="ml-auto">
                                        <a v-if="authorize('modify',question)" @click.prevent="edit" class="btn btn-outline-info btn-sm">Izmena</a>
                                        <button v-if="authorize('deleteQuestion',question)" class="btn btn-outline-danger btn-sm" @click="destroy">Obrisi</button>
                                   </div>
                               </div>
                               <div class="col-4"></div>
                               <div class="col-4">
                                    <user-info :model="question" label="Pitao"></user-info>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import Vote from "./Vote";
import UserInfo from "./UserInfo";
import modification from '../mixins/modification.js';
export default {
    props:['question'],
    components:{
        Vote,
        UserInfo
    },
    mixins:[modification],
    data(){
        return{
            title:this.question.title,
            body:this.question.body,
            bodyHtml:this.question.body_html,
            id:this.question.id,
            beforeEditCase:{}

        }
    },
    computed:{
        isInvalid() {
            return this.body.length < 10 || this.title.length <10;
        },
        endpoint(){
            return `/questions/${this.id}`;
        }
    },
    methods:{
        setEditCache(){
            this.beforeEditCase = {
                body:this.body,
                title:this.title
            }
        },
        restoreFromCache(){
            this.body = this.beforeEditCase.body;
            this.title = this.beforeEditCase.title;
        },
        payload(){
            return {
                body:this.body, 
                title:this.title    
            }
        },
        delete(){
            axios.delete(this.endpoint).then(
                ({data})=>{
                    this.$toast.success(data.message,'Uspešno',{timeout:2000,position: "topRight"});
                }
            );
            setTimeout(()=>{
                window.location.href="/questions";
            },3000);
        }
    }

}
</script>