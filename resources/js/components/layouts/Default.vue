<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/dashboard" >Survey</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <router-link :to="{name:'dashboard'}" class="nav-link">Home </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name:'stat'}" class="nav-link">Stat </router-link>
                        </li>
                        <li v-if="user.is_admin" class="nav-item">
                            <router-link :to="{name:'users'}" class="nav-link">Users (did not fill survey)</router-link>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ user.name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="javascript:void(0)" @click="logout">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <main class="mt-3">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        name:"default-layout",
        data(){
            return {
                user:this.$store.state.auth.user,
            }
        },
        computed: {
            ...mapGetters([
                'surveyStatus'
            ])
        },
        mounted() {
            this.surveyStatusCall()
            console.log('Default Component mounted.')
        },
        methods:{
            ...mapActions({
                signOut:"auth/logout",
                surveyStatusCall:"store/surveyStatus",
            }),
            async logout(){
                await axios.post('/logout').then(({data})=>{
                    this.signOut()
                    this.$router.push({name:"login"})
                })
            }
        }
    }
</script>