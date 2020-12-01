export default {
    data(){
        return{
            izmena:false 
        }
    },
    methods:{
        edit(){
            this.setEditCache();
            this.izmena = true
        },
        cancel(){
            this.restoreFromCache();
            this.izmena = false
        },
        setEditCache(){},
        restoreFromCache(){

        },
        update(){
            axios.put(this.endpoint,this.payload())
            .catch(({response})=>{
                this.$toast.error(response.data.message,'Greška',{
                    timeout:3000,position: "topRight"});
            })
            .then(({data})=>{
                this.bodyHtml = data.body_html;
                this.$toast.success(data.message,'Uspešno',{
                    timeout:3000,position: "topRight"});
                this.izmena=false
            });
        },
        payload(){},
        destroy(){
            this.$toast.question('Da li ste sigurni?','Brisanje',{
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                position: 'center',
                buttons: [
                    ['<button><b>DA</b></button>', (instance, toast) => {
            
                        this.delete();
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ]
            });
        },
        delete(){}

    }

}