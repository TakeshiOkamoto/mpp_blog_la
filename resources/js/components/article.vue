<template>
<div>
  <p></p>
  
  <!-- 初期時にはitem.category_idがnullになるので回避 -->
  <template v-if="item != null && item.category_id != null">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">ホーム</router-link></li>
        <li class="breadcrumb-item"><router-link v-bind:to="{ name:'Category', params: {id: item.category_id, page: 1} }">{{ item.category_name }}</router-link></li>
        <li class="breadcrumb-item active">{{ item.title }}</li>
      </ol>
    </nav>
    
    <p></p>
    <div v-html="item.body"></div>
    <p></p>
    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">ホーム</router-link></li>
        <li class="breadcrumb-item"><router-link v-bind:to="{ name:'Category', params: {id: item.category_id, page: 1}}">{{ item.category_name }}</router-link></li>
        <li class="breadcrumb-item active">{{ item.title }}</li>
      </ol>
    </nav>
  </template>
</div>  
</template>

<script>

// Ajax
import axios from 'axios';

// ミックスイン
import Mixin from '../mixin.js'

export default {

  // ---------------------
  //  データ定義
  // ---------------------
  data: function () {
    return {
      item: {}, // アイテム
      id: 0     // ID
    }  
  },
  
  // ---------------------
  //  作成時
  // ---------------------    
  created() {
    this.id = this.$route.params.id
    this.run_ajax();
  },

  // ---------------------
  //  ウォッチャー
  // --------------------- 
  // $routeが変更されたときにidを再設定する
  watch: {
    '$route'(to, from) {
      this.id = to.params.id;
      this.run_ajax();
     }
  },
    
  // ---------------------
  //  メソッド
  // ---------------------
  mixins: [Mixin],
  methods: {
    
    // JSONデータの取得
    run_ajax: function() {
      
      axios({
        method  : "GET",
        baseURL : "http://localhost:8000/api/articles?id=" + this.id,
        data    : "",
        headers : {
          // JSON
          'Content-Type': 'application/json',
          // CSRFトークン
          // ※AxiosはCookie(Laravelが自動生成)に「X-XSRF-TOKEN」があると、そのヘッダを自動的に送信するので以下は不要
          // https://readouble.com/laravel/6.x/ja/csrf.html 
          //'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
        }
      })
      .then(response  => {

        // データ 
        this.item = response.data[0];
        
        // 次は動的変更なのでSEO的には評価されないかも？
        if (this.item){
          document.title = this.item.title;    
          document.querySelector('meta[name="keywords"]').setAttribute('content',this.item.keywords);
          document.querySelector('meta[name="description"]').setAttribute('content',this.item.description);
        }
      }) 
      .catch(err => {
          alert(err);
      });   
    }   
  },  
  
  // ---------------------
  //  算出プロパティ
  // ---------------------
  computed: {  
    // none
  }  
}
</script>

<style scoped>
</style>
