<template>
  <div class="container pt-5">
    <!-- HEADER -->
    <div class="row justify-content-left">
      <h1 class="mr-5">
        Tasks
        <i class="fas fa-tasks"></i>
      </h1>
      <button type="button p-0" class="btn btn-primary" @click="showModalNew()">
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
            <td v-text="task.active ? 'Running': 'Pause'"></td>
            <td>
              <stopwatch :active="task.active" :endsAt="task.endsAt"></stopwatch>
            </td>
            <td>
              <playbutton
                class="action-button"
                :state="task.active"
                @click="playbuttonPressed(task)"
              ></playbutton>
              <i
                title="Edit task"
                class="action-button fas fa-pen-square"
                aria-hidden="true"
                @click="showModalEdit(task)"
              ></i>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- NEW TASK -->
    <modal v-if="modal" @close="closeModals()" v-cloak>
      <div class="modal-header">
        <h5 class="modal-title">{{formData.title}}</h5>
        <button type="button" class="btn" @click="closeModals()">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label for="full-name">Hours</label>
          <input
            class="form-control"
            min="0"
            max="99"
            type="number"
            :class="[formErrors.hours ? 'is-invalid' : '']"
            v-model.number="formData.hours"
            placeholder
          >
          <div class="invalid-feedback" v-if="formErrors.hours">Please enter a number between 0-99</div>
        </div>

        <div class="form-group">
          <label for>Minutes</label>
          <input
            type="number"
            min="0"
            max="99"
            class="form-control"
            :class="[formErrors.minutes ? 'is-invalid' : '']"
            v-model.number="formData.minutes"
            placeholder
          >
          <div class="invalid-feedback" v-if="formErrors.minutes">Please enter a number between 0-99</div>
        </div>

        <div class="form-group">
          <label for>Seconds</label>
          <input
            type="number"
            min="0"
            max="99"
            class="form-control"
            :class="[formErrors.seconds ? 'is-invalid' : '']"
            v-model.number="formData.seconds"
            placeholder
          >
          <div class="invalid-feedback" v-if="formErrors.seconds">Please enter a number between 0-99.</div>
        </div>

        <label
          v-if="ajaxFormError"
          for
          class="text-danger"
        >Error ocurred while saving new task, please check your info</label>
      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-secondary mr-1" @click="closeModals()">Cancel</button>
        <button type="submit" class="btn btn-primary mr-1" @click="validateAndSave()">Save</button>
      </div>
    </modal>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      modal: false,

      tasks: [
        {
          id: 1,
          name: "Dummy task",
          lastUpdate: 1550523893,
          hours: 0,
          minutes: 0,
          seconds: 10,
          endsAt: 1550527493,
          active: true
        },

        {
          id: 2,
          name: "Dummy task 2",
          lastUpdate: 1550523893,
          hours: 0,
          minutes: 0,
          seconds: 10,
          endsAt: 1550527493,
          active: false
        }
      ],
      formData: {},
      formErrors: {},
      ajaxFormError: false
    };
  },

  components: {
    stopwatch: require("../components/Stopwatch.vue").default,
    playbutton: require("../components/PlayButton.vue").default,
    modal: require("../components/Modal.vue").default
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
      this.formErrors = {};
      this.formData = {
        title: "New task",
        hours: 0,
        minutes: 0,
        seconds: 0
      };

      this.modal = true;
    },

    showModalEdit: function() {
      console.log("Edit task window");
    },

    playbuttonPressed: function() {
      console.log("Play button pressed");
    },

    closeModals: function() {
      this.modal = false;
      this.formData = {};
    }
  }
};
</script>

<style>
.action-button {
  font-size: 25px;
  cursor: pointer;
  margin-left: 5px;
}

.action-button:hover {
  color: #6d53e2;
}

.action-button:active {
  color: #e1ddf1;
}
</style>

