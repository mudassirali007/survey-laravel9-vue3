<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Survey</div>
                    <div class="container">
                        <div class="jumbotron mt-3">
                            <template v-if="!surveyStatus">
                                <div v-if="page1" >
                                    <div v-for="question in questions.slice(0,5)">
                                        <h4 class="mt-5 mb-3">{{ question.question }}</h4>
                                        <div v-for="(answer, index) in answers" class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio"
                                                       :value="index"
                                                       :name="question.id"
                                                       @input="answerSelected(question.id,answer)">
                                                {{answer}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <button :class="`${responses.length === 5 ? '' : 'disabled'}`" class="btn btn-secondary m-1" @click="()=>{page1 = false; page2 = true}">
                                            next
                                        </button>
                                    </div>
                                </div>
                                <div v-if="page2" >
                                    <div v-for="question in questions.slice(5)">
                                        <h4 class="mt-5 mb-3">{{ question.question }}</h4>
                                        <div v-for="(answer, index) in answers" class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio"
                                                       :value="index"
                                                       :name="question.id"
                                                       @input="answerSelected(question.id,answer)">
                                                {{answer}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <button
                                                class="btn btn-primary m-1"
                                                @click="()=>{page1 = true; page2 = false}">
                                            prev
                                        </button>

                                        <button :class="`${responses.length === 10 ? '' : 'disabled'}`"
                                                class="btn btn-secondary m-1" @click="finish">
                                            Finish
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PieChart from '@/components/Chart/PieChart.vue'
    import { mapGetters, mapMutations, mapActions } from 'vuex'
    import router from '@/router'

    export default {
        name:"Survey",
        components: {
            PieChart
        },
        computed: {
            ...mapGetters([
                'surveyStatus'
            ])
        },
        data(){
            return {
                questions:this.$store.state.store.question,
                surveyStatus:this.$store.state.store.surveyStatus,
                answers:['Yes','No'],
                page1:true,
                page2:false,
                questionIndex: 0,
                responses: [],
                errors: [],
                error: '',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            ...mapActions({
                surveyStatusCall:"store/surveyStatus",
            }),
            async answerSelected(questionId,answer){
                const index = this.responses.findIndex(({questionId:id}) => id === questionId)
                if(index > -1){
                    this.responses[index] = {
                        questionId : questionId,
                        answer : answer
                    }
                } else {
                    this.responses.push({
                        questionId : questionId,
                        answer : answer
                    })
                }
                await axios.post('/api/survey',{
                    questionId : questionId,
                    answer : answer
                }).then(response=>{
                }).catch(({response})=>{
                    if(response.status===422){
                        console.log(response.data.errors)
                    }else{
                        alert(response.data.message)
                    }
                }).finally(()=>{

                })

            },
            async finish() {
                await axios.get('/api/surveyTaken').then(async response=>{
                    await this.surveyStatusCall()
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
