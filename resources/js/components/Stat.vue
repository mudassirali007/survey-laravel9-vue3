<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Stats</div>
                    <div class="container">
                        <div class="jumbotron mt-3">
                            <div>
                                <template v-for="(data) in surveyStatData">
                                    <h5 style="margin: auto;width: 50%;padding: 10px;">{{data.qs}}</h5>
                                    <PieChart :data="[data.Yes,data.No]" />
                                </template>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PieChart from '@/components/Chart/PieChart.vue'

    export default {
        name:"Stat",
        components: {
            PieChart
        },
        computed: {

        },
        data(){
            return {
                surveyStatus:this.$store.state.store.surveyStatus,
                surveyStatData:[],
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.surveyStat()
        },
        methods:{
            async surveyStat(){
                await axios.get('/api/surveyStat').then(response=>{
                    this.surveyStatData =  response.data
                }).catch(({response})=>{
                    if(response.status===422){
                        console.log(response.data.errors)
                    }else{
                        alert(response.data.message)
                    }
                })
            },

        }
    }
</script>
