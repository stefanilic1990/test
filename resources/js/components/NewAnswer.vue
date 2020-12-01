<template>
    <div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3>Your Answer</h3>
                        </div>
                        <hr>
                        <form @submit.prevent="create">
                            <div class="form-group">
                                <textarea name="body" rows="7" class="form-control" required v-model="body"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary btn-lg" :disabled="isInvalid">Postavi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['questionId'],
    methods:{
        create(){
            axios.post(`/questions/${this.questionId}/answers`,{
                body:this.body
            })
            .catch(error=>{
                this.$toast.warning(error.response.data.message,'Greška',{
                    timeout:3000,position: "topRight"});
            })
            .then(({data})=>{
                this.$toast.success(data.message,'Uspešno',{
                    timeout:3000,position: "topRight"
                });
                this.body =""; 
                this.$emit('created',data.answer);
            });
        }
    },
    data(){
        return {
            body:""
        }
    },
    computed:{
        isInvalid(){
            return !this.signedIn || this.body.length < 10;
        }
    }
}
</script> 