<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users List</div>

                    <div v-if="users"  class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                                </thead>
                                <tbody v-if="users">
                                <tr v-for="(user,index) in users.data" :key="index">
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                <tr>
                                    <td align="center" colspan="3">No record found.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination align="center" :data="users" @pagination-change-page="usersList"></pagination>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapMutations, mapActions } from 'vuex'
    import router from '@/router'
    import pagination from 'laravel-vue-pagination'

    export default {
        name:"Users",
        components:{
            pagination
        },
        computed: {
            ...mapGetters([
                'surveyStatus'
            ])
        },
        data(){
            return {
                users:{
                    type:Object,
                    default:null
                }
            }
        },
        mounted() {
            this.usersList()
            console.log('Component mounted.')
        },
        methods:{
            async usersList(page=1){
                await axios.get(`/api/usersList?page=${page}`).then(({data})=>{
                    this.users = data
                }).catch(({ response })=>{
                    console.error(response)
                })
            }

        }
    }
</script>
<style scoped>
    .pagination{
        margin-bottom: 0;
    }
</style>