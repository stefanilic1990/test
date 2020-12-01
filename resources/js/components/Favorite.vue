<template>
<div>
    <a href="" title="Click to mark a favorite question" :class="classes" @click.prevent="toggle"><i class="fas fa-star fa-2x"></i>
    <span class="favotite_count">{{count}}</span>
    </a>
</div>
    
</template>
<script>
export default {
    props:['question'],
    data(){
        return {
            isFavorited:this.question.is_favorited,
            count: this.question.favorites_count,
            id:this.question.id
        }
    },
    computed:{
        classes(){
            return [
                'favorite','mt-3',
                ! this.signedIn? 'off': (this.isFavorited ? 'favorited': '')
            ]
        },
        endpoint(){
            return `/questions/${this.id}/favorite`;
        }
    },
    methods:{
        toggle() {
            if(!this.signedIn){
                this.$toast.warning("Molimo vas da se prijavite da bi odabrali omiljeno pitanje",'',{
                    timeout:3000,position: "topRight"});
                return;
            }
            this.isFavorited ? this.destroy() : this.create();
        },
        destroy(){
            axios.delete(this.endpoint)
            .then(res=>{
                this.count--;
                this.isFavorited = false;
            });
        },
        create(){
            axios.post(this.endpoint)
            .then(res=>{
                this.count++;
                this.isFavorited = true;
            });
        }
    }
}
</script>