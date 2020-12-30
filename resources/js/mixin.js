// 日時操作
import {format} from 'date-fns'
import ja from 'date-fns/locale/ja'

export default {
  
  // ---------------------
  //  メソッド
  // ---------------------    
  methods: {
    
    // ---------------------      
    //  日付操作 
    // ---------------------      
    formatConversion: function(created_at) {
      
      // IE11対策で日付形式をISO 8601に変換する
      // 変換前： 2019-01-01 00:00:00
      // 変換後： 2019-01-01T00:00:00.000Z
      if (typeof created_at !== 'object' && created_at.indexOf('T') === -1){
        const a = created_at.slice(0,10);
        const b = 'T'
        const c = created_at.slice(11);   
        const d = '.000Z'; 
        created_at =  a + b + c + d;
      }
            
      return format(new Date(Date.parse(created_at)), 'yyyy年MM月dd日(iiiii) HH:mm:ss', { locale: ja });
    },
    
    // ---------------------      
    //  ページネーション 
    // --------------------- 
    // ? - ? の部分を生成する
    getPaginationNow: function() {
      
      if (!this.page || this.page == 1){
        if (this.per > this.record_count_all){
          return "1 - " + this.record_count_all;
        }else{
          return "1 - " + this.per;
        }
      }else{
        let st = (this.page - 1) * this.per + 1;
        let en = (st + (this.record_count -1));
        return  st + " - " + en;         
      } 
    }        
  }  
}