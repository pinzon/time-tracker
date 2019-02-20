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
            <td v-text="task.secondsLeft > 0 ?  (task.active ? 'Running' : 'Paused') : 'Ended'"></td>
            <td>
              <stopwatch :active="task.active" :seconds.sync="task.secondsLeft"></stopwatch>
            </td>
            <td>
              <playbutton
                class="action-button"
                :state="task.active"
                @click="playbuttonPressed(task,index)"
              ></playbutton>
              <i
                title="Edit task"
                class="action-button fas fa-pen-square"
                aria-hidden="true"
                @click="showModalEdit(task,index)"
              ></i>
              <i
                title="Delete task"
                class="action-button fas fa-trash-alt"
                aria-hidden="true"
                @click="showModalDelete(task,index)"
              ></i>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- NEW & EDIT TASK -->
    <modal v-if="modal" @close="closeModals()" v-cloak>
      <div class="modal-header">
        <h5 class="modal-title">{{formData.title}}</h5>
        <button type="button" class="btn" @click="closeModals()">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label>Name</label>
          <input
            class="form-control"
            type="text"
            :class="[formErrors.name ? 'is-invalid' : '']"
            v-model.trim="formData.name"
            placeholder="Name"
          >
          <!-- <div class="invalid-feedback" v-if="formErrors.hours">Please enter a number between 0-99</div> -->
        </div>

        <div class="form-group">
          <label>Hours</label>
          <input
            class="form-control"
            min="0"
            max="99"
            type="number"
            :class="[formErrors.hours ? 'is-invalid' : '']"
            v-model.number="formData.hours"
            placeholder
          >
          <!-- <div class="invalid-feedback" v-if="formErrors.hours">Please enter a number between 0-99</div> -->
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
          <!-- <div class="invalid-feedback" v-if="formErrors.minutes">Please enter a number between 0-99</div> -->
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
          <!-- <div class="invalid-feedback" v-if="formErrors.seconds">Please enter a number between 0-99.</div> -->
        </div>

        <label
          v-if="ajaxFormError"
          class="text-danger"
        >Error ocurred while saving task, please check your info</label>
      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-secondary mr-1" @click="closeModals()">Cancel</button>
        <button type="submit" class="btn btn-primary mr-1" @click="submitForm()">Save</button>
      </div>
    </modal>

    <!-- DELETE TASK -->
    <modal v-if="modalDelete" @close="closeModals()" v-cloak>
      <div class="modal-header">
        <h5 class="modal-title">Deleting task</h5>
        <button type="button" class="btn" @click="closeModals()">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        Are you sure to delete this Tasks?
        <label
          v-if="ajaxFormError"
          class="text-danger"
        >Error ocurred while saving task, please check your info</label>
      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-secondary mr-1" @click="closeModals()">Cancel</button>
        <button type="submit" class="btn btn-danger mr-1" @click="submitForm()">DELETE</button>
      </div>
    </modal>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      modal: false,
      modalDelete: false,
      csrf_token: $('meta[name="csrf-token"]').attr("content"),
      tasks: [],
      method: 0, // 0 = New; 1 = Edit; 2 = delete
      itemIndex: null,
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
      var component = this;
      var token = component.csrf_token;
      $.ajax({
        type: "GET",
        url: "/task",
        data: { _token: token }
      })
        .done(function(result) {
          component.tasks = result.tasks;
        })
        .fail(() => (component.tasks = []));
    },

    showModalNew: function() {
      this.formErrors = {};
      this.action = 0; //New
      this.formData = {
        title: "New task",
        hours: 0,
        minutes: 0,
        seconds: 0,
      };

      this.modal = true;
    },

    showModalEdit: function(task,index) {
      this.itemIndex = index
      this.formErrors = {};
      this.action = 1; //Edit
      this.formData = {
        id: task.id,
        title: "Edit task",
        name: task.name ,
        hours: task.hours,
        minutes: task.minutes,
        seconds: task.seconds,
      };

      this.modal = true;
      console.log("Edit task window");
    },

    showModalDelete: function(task) {
      this.itemIndex = index
      this.formErrors = {};
      this.action = 2; // Delete
      this.formData = { id: task.id };
      this.modalDelete = true;
      console.log("Edit task window");
    },

    submitForm: function() {
      switch (this.action) {
        case 0:
          this.postNewTask();
          break;
        case 1:
          this.updateTask();
          break;
        case 2:
          this.deleteTask();
          break;
        default:
          this.closeModals();
      }
    },

    postNewTask: function() {
      var component = this;
      this.formData["_token"] = component.csrf_token;
      $.ajax({
        type: "POST",
        url: "/task",
        data: component.formData
      })
        .done(function(result) {
          component.tasks.push(result.task);
          component.closeModals();
        })
        .fail(function() {
          component.ajaxFormError = true;
        });
    },

    updateTask: function() {
      var component = this;
      this.formData["_token"] = component.csrf_token;
      $.ajax({
        type: "PUT",
        url: "/task",
        data: component.formData
      })
        .done(function(result) {
          if(result.error == 0){
            component.tasks[component.itemIndex] = result.task
            component.closeModals();
          }else{
            component.ajaxFormError = true;
          }
        })
        .fail(function() {
          component.ajaxFormError = true;
        });
    },

    deleteTask: function() {
      var component = this;
      this.formData["_token"] = component.csrf_token;
      $.ajax({
        type: "DELETE",
        url: "/task",
        data: component.formData
      })
        .done(function(result) {
          component.tasks.splice(component.itemIndex,1)
          component.closeModals();
        })
        .fail(function() {
          component.ajaxFormError = true;
        });
    },

    playbuttonPressed: function() {
      console.log("Play button pressed");
    },

    closeModals: function() {
      this.itemIndex = null
      this.modal = false;
      this.modalDelete = false;
      this.formData = {};
      this.formErrors = {};
      this.action = 0;
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

