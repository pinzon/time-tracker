<template>
  <div class="container pt-5">
    <!-- HEADER -->
    <div class="row justify-content-left">
      <h1 class="mr-5">
        Tasks
        <i class="fas fa-tasks"></i>
      </h1>
      <button type="button p-0" class="btn btn-primary">
        <i class="fas fa-plus"></i> New
      </button>
    </div>

    <!--TASKS LIST -->
    <div class="row pt-5">
      <table class="table">
        <thead>
          <td scope="col">#</td>
          <td scope="col">Name</td>
          <td scope="col">Status</td>
          <td scope="col">Timer</td>
          <td scope="col">Actions</td>
        </thead>
        <tbody>
          <tr v-for="(task,index) in tasks" :key="index">
            <td v-text="index + 1"></td>
            <td v-text="task.name"></td>
            <td v-text="task.active ? 'Activo': 'En Pausa'"></td>
            <td>
                <stopwatch :active="task.active" :endsAt="task.endsAt"></stopwatch>
            </td>
            <td>
              
            </td>
            
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      tasks: [
        {
          id: 1,
          name: "Dummy task",
          updatedAt: 1550523893,
          endedAd: 1550527493,
          active: true
        }
      ],
      formData: {}
    };
  },

  components:{
      'stopwatch' : require('../components/Stopwatch.vue').default,
      'playbutton' : require('../components/PlayButton.vue').default,

  },

  mounted() {
    console.log("Page mounted.");
    this.getTasks();
  },

  methods: {
    getTasks: function() {
      console.log("Tasks retrieved");
    },

    showModalNew: function() {
      console.log("Tasks complete");
    }
  }
};
</script>

<style>
</style>

