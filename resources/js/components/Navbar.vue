<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      NOTES
    </RouterLink>
    <div class="navbar__menu">
        <button class="button" @click="showForm = ! showForm">
          <i class="icon ion-md-add"></i>
          note作成
        </button>
    </div>
    <NoteForm v-model="showForm" />
  </nav>
</template>

<script>
import NoteForm from './NoteForm.vue'
export default {
  name:'Navbar',
  components: {
    NoteForm
  },
  data () {
    return {
      showForm: false
    }
  },
}
</script>