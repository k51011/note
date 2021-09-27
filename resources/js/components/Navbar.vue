<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      NOTES
    </RouterLink>
    <div style="display: flex; justify-content: right;">
      <div class="navbar__menu">
        <button class="button" @click="showForm = ! showForm">
          <i class="icon ion-md-add"></i>
          note作成
        </button>
      </div>
      <NoteForm v-model="showForm" />
      <button class="button" @click="showForm2 = ! showForm2">
        進捗確認
      </button>
      <Progress v-model="showForm2" />
    </div>
  </nav>
</template>

<script>
import NoteForm from './NoteForm.vue'
import Progress from './Progress.vue'
export default {
  name:'Navbar',
  components: {
    NoteForm,
    Progress
  },
  data () {
    return {
      showForm: false,
      showForm2: false
    }
  },
}
</script>

<style>
  .button {
    margin-right: 10px;
  }
</style>