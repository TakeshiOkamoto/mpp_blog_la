import Vue from 'vue'
import Router from 'vue-router'
import Home from './components/home.vue'
 
Vue.use(Router)
 
export default new Router({
  
  // ---------------------  
  //  モードの設定
  // ---------------------    
  // modeのデフォルトは「hashモード」です。
  mode: 'hash',
 
  // 1. hashモード
  // web.phpの設定は不要です。
  
  // [URLの例]
  // http://localhost:8000/#/
  // http://localhost:8000/#/article/5
  // http://localhost:8000/#/article/33
  
  // 2. historyモード
  // web.phpの設定が必要です。
  
  // [URLの例]
  // http://localhost:8000/
  // http://localhost:8000/article/5
  // http://localhost:8000/article/33
  
  // Vue Routerの使い方 ※historyモード
  // https://www.petitmonte.com/php/laravel-vue-router.html
  
  // 3. abstractモード
  // 詳細は公式サイトへ https://router.vuejs.org/ja/api/#mode
  
  // ---------------------  
  //  アプリのベースURL
  // ---------------------  
  base: process.env.BASE_URL,
  
  // ---------------------  
  //  ルーターの設定
  // ---------------------  
  routes: [
  
    // ホーム
    {
      path: '/:page?', // ?を付与しているので引数がないトップページも表示可能
      name: 'Home',
      
      // 同期でコンポーネントを呼び出す
      component: Home
    },
    
    // 各記事
    {
      path: '/article/:id',
      name: 'Article',
      
      // 非同期でコンポーネントを呼び出す
      // ※Homeのようにimportしたコンポーネントを設定するのでも可
      component: () => import('./components/article.vue')
    },    
    
    // 各カテゴリ
    { 
      path: '/category/:id/page/:page',
      name: 'Category',
      
      // 非同期でコンポーネントを呼び出す
      // ※Homeのようにimportしたコンポーネントを設定するのでも可
      component: () => import('./components/category.vue')
    },       
  ],
  
  // ---------------------  
  //  スクロール制御
  // ---------------------  
  // ※公式参照
  // https://router.vuejs.org/ja/guide/advanced/scroll-behavior.html  
  scrollBehavior(to, from, savedPosition) {

    // ブラウザの戻る/進むボタンを押した際、スクロールを元の位置へ移動する
    if (savedPosition) {
      
      return savedPosition
      
    } else {
      // ハッシュ(#)のとき、その位置へ移動する ※今回は未使用
      if (to.hash) {
        return { selector: to.hash }
        
      // それ以外はスクロールをトップへ
      } else {
        return { x: 0, y: 0 }
      }
    }
  }  
})
