import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import NoteList from './pages/NoteList.vue'
import NoteHighList from './pages/NoteHighList.vue'
import NoteMiddleList from './pages/NoteMiddleList.vue'
import NoteLowList from './pages/NoteLowList.vue'
import NoteProgressList from './pages/NoteProgressList.vue'
import NoteCompletionList from './pages/NoteCompletionList.vue'
import FavoriteList from './pages/FavoriteList.vue'
import NoteDetail from './pages/NoteDetail.vue'
import NoteEdit from './pages/NoteEdit.vue'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: NoteList
  },
  
  {
    path: '/high',
    component: NoteHighList
  },
  
  {
    path: '/middle',
    component: NoteMiddleList
  },
  
  {
    path: '/low',
    component: NoteLowList
  },
  
  {
    path: '/progress',
    component: NoteProgressList
  },
  {
    path: '/completion',
    component: NoteCompletionList
  },
  {
    path: '/favorite',
    component: FavoriteList
  },
  
  
  {
    path: '/notes/:id',
    component: NoteDetail,
    props: true
  },
  
  {
    path: '/notes/:id/edit',
    component: NoteEdit,
    props: true
  },
  
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
  mode: 'history',
  routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router