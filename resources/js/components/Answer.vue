<template>
    <div>
        <div class="media post">
            <vote :model="answer" name="answer" ></vote>
            <div class="media-body">
                <form v-if="izmena"  @submit.prevent="update" >
                    <div class="form-group">
                        <textarea name="" v-model="body" rows="10" class="form-control" required></textarea>
                    </div>
                <button type="submit"   class="btn btn-primary" :disabled="isInvalid">Izmena</button>
                <button @click = "cancel"  class="btn btn-danger" >Odustani</button>
                </form>
                <div v-else>
                    <div v-html="bodyHtml"></div>
                    <div class="row">
                        <div class="col-4">
                            <div class="ml-auto">
                                <a v-if="authorize('modify',answer)" @click.prevent="edit" class="btn btn-outline-info btn-sm">Izmena</a>
                                <button v-if="authorize('modify',answer)" class="btn btn-outline-danger btn-sm" @click="destroy">Obrisi</button>
                            </div>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <user-info :model="answer" label="Odgovorio"></user-info>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <hr>
    </div>
     
</template>


<script>
import Vote from "./Vote";
import UserInfo from "./UserInfo";
import modification from '../mixins/modification.js';
export default {
    props:['answer'],
    components:{
        Vote,
        UserInfo
    },
    mixins:[modification],
    data(){
        return {
            body:this.answer.body,
            bodyHtml: this.answer.body_html,
            id:this.answer.id,
            questionId:this.answer.question_id,
            beforeEditCache:null
        }
    },
    methods:{
        setEditCache(){
            this.beforeEditCache = this.body
        },
        restoreFromCache(){
            this.body = this.beforeEditCache
        },
        payload(){
            return {
                body:this.body
            }
        },
        delete(){
            axios.delete(this.endpoint).then(
                ({data})=>{
                    this.$toast.success(data.message,'Uspešno',{
                    timeout:3000,position: "topRight"});
                    this.$emit('deleted');
                }
            );
        }
    },
    computed:{
        isInvalid(){
            return this.body.length<10;
        },
        endpoint(){
            return `/questions/${this.questionId}/answers/${this.id}`;
        }
    }
}
</script>