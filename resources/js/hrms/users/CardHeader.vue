<template>
<div class="user-block" v-if="(user != null && typeof(user) != 'undefined')">
    <img class="img-circle" :src="'/img/profile/'+(user != null ? user.image : 'default.png')" alt="User Image">
    <span class="username"><a class="text-danger">{{user.first_name+' '+user.last_name}}</a></span>
    <span v-if="activity != null && activity.name != null" class="description">{{activity.name}} - {{activity.created_at | recentDate}}</span>
</div>
</template>
<script>
export default {
    data(){
        return  {}
    },
    mounted() {},
    created() {},
    methods:{},
    props:{
        activity: Object,
        user: Object,
    }
}
</script>