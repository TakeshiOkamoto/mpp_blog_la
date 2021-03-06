<template>
<div>
  <template v-if="items.length != 0">
    <p>Vue Routerのモードは「hash」です。ブラウザのURLの変化をご確認ください。</p>
    
    <!-- 記事 -->
    <div v-for="(item, index) in items">     
      <div v-bind:key="item.id" class="card" style="padding:18px;"> 
        <div>   
          <router-link v-bind:to="{ name: 'Article', params: {id: item.id } }">{{ item.title }}</router-link>
          <div>
            {{ formatConversion(item.created_at) }} 
            &nbsp;
            <router-link v-bind:to="{ name: 'Category', params: {id: item.category_id, page: 1} }" class="badge badge-custom">{{ item.category_name }}</router-link>
          </div>
        </div>            
        {{ item.description }}
      </div>
    </div>    
    
    <p></p>

    <!-- ページネーション -->
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <div v-for="i in total_pages">   
          <template v-if="i == page">
            <li class="page-item active"><router-link tag="a" v-bind:to="{ name: 'Home', params: {page: i}}" class="page-link">{{ i }}</router-link></li>  
          </template>   
          <template v-else>   
            <li class="page-item"><router-link tag="a" v-bind:to="{ name: 'Home', params: { page: i }}" class="page-link">{{ i }}</router-link></li>
          </template>  
        </div>
      </ul>
    </nav>
    <p>全{{ record_count_all }}件中 {{ getPaginationNow() }}件の記事が表示されています。</p>
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
      items: [],          // アイテム
      page: 1,            // [ページネーション]現在のページ(番号)
      per: 1,             // [ページネーション]データの表示件数  
      total_pages: 1,     // [ページネーション]全ページ数  
      record_count: 1,    // レコード件数    
      record_count_all: 1 // レコード件数(全て)
    }
  },
  
  // ---------------------
  //  作成時
  // ---------------------    
  created() {
    if(this.$route.params.page){
      this.page = this.$route.params.page;
    }
    this.run_ajax();          
  },

  // ---------------------
  //  ウォッチャー
  // --------------------- 
  // $routeが変更されたときにpageを再設定する
  watch: {
    '$route'(to, from) {
      this.page = to.params.page;
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
        baseURL : "http://localhost:8000/api/pagination?category_id=-1&page=" + this.page,
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
        this.items            = response.data.articles; 
        this.page             = response.data.page;
        this.per              = response.data.per; 
        this.total_pages      = response.data.total_pages;
        this.record_count     = response.data.record_count;
        this.record_count_all = response.data.record_count_all;   
        
        if (this.items){
          document.title = "Laravel + Vue.jsで作るSPAのブログシステム";    
          document.querySelector('meta[name="keywords"]').setAttribute('content',"spa,vue");    
          document.querySelector('meta[name="description"]').setAttribute('content',"フルSPAのブログシステムです。(学習用)");
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
.badge-custom {
  color: #fff;
  background-color: #6c757d;
}

.badge-custom:hover, 
.badge-custom:focus {
  color: #fff;
  background-color: #007bff;
  cursor: pointer;
}

.badge-custom:focus{
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
  cursor: pointer;
}
.card:hover {
  color: #212529;
  background-color: rgba(0, 0, 0, 0.075);
}
</style>
