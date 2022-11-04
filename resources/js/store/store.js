import axios from 'axios'
import router from '@/router'

export default {
    namespaced: true,
    state:{
        question:{},
        surveyStatus: false,
    },
    getters:{
        question(state){
            return state.question
        },
        surveyStatus(state){
            return state.surveyStatus
        },
    },
    mutations:{
        SET_QUESTION (state, value) {
            state.question = value
        },
        SET_SURVEY_STATUS (state, value) {
            state.surveyStatus = value
        },
    },
    actions:{
        question({commit}){
            return axios.get('/api/question').then(({data})=>{
                commit('SET_QUESTION',data)
            }).catch(({response:{data}})=>{
                commit('SET_QUESTION',{})
            })
        },
        surveyStatus({commit,dispatch }){
            return axios.get('/api/survey').then(response=>{
                commit('SET_SURVEY_STATUS',response.data)
                if(response.data) {
                    router.push({name:'stat'})
                }
                else {
                    dispatch("question");
                    router.push({name:'survey'})
                }
            }).catch(({response})=>{
                commit('SET_SURVEY_STATUS',false)
            })
        },
    }
}