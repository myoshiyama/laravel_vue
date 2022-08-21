<template>
    <div>
        <div v-if="loading">データ読み込み中...</div>
        <div v-else>
            <div class="row mb-4" v-for="row in rows" :key="'row' + row">
                <div 
                    class="col d-flex align-item-stretch" 
                    v-for="(bookable, column) in bookablesInRow(row)" 
                    :key="'row' + row + column"
                >
                    <bookable-list-item v-bind="bookable"></bookable-list-item>
                </div>
                
                <div class="col" v-for="p in placeholdersInRow(row)" :key="'placeholder' + row + p"></div>
            </div>

            <div class="text-center">
                <span role="button" class="d-inline-block px-2" @click="loadBookables()">最初</span>
                <span role="button" class="d-inline-block px-2" @click="loadBookables(Math.max(meta.current_page - 1, 1))">前へ</span>
                <span v-for="pageNum in pageNums">
                    <span
                        @click="loadBookables(pageNum)"
                        role="button"
                        :class="{ 'font-weight-bolder': pageNum === meta.current_page }"
                        class="d-inline-block px-2">{{pageNum}}</span>
                </span>
                <span role="button" class="d-inline-block px-2" @click="loadBookables(Math.min(meta.current_page + 1, meta.last_page))">次へ</span>
                <span role="button" class="d-inline-block px-2" @click="loadBookables(meta.last_page)">最後</span>
            </div>
        </div>
    </div>
</template>

<script>
import BookableListItem from './BookableListItem';

export default {
    components: {
        BookableListItem
    },
    data(){
        return{
            bookables: null,
            loading: false,
            columns: 3,
            meta: null
        };
    },
    computed:{
        rows(){
            return this.bookables === null
            ? 0
            :Math.ceil(this.bookables.length / this.columns);
        },
        pageNums(){
            const currPage = this.meta.current_page;
            const lastPage = this.meta.last_page;
            const sequentialNumsLen = Math.min(10, lastPage); 
            const sequentialNums = new Array(sequentialNumsLen).fill(0).map((_, idx) => idx + 1); 
            if (lastPage < 10 || currPage <= 5) {
                return sequentialNums;
            }
            if (lastPage - 4 <= currPage) {
                return sequentialNums.map((_, idx) => lastPage - 9 + idx); 
            }
            return sequentialNums.map((_, idx) => currPage - 5 + idx); 
        }
    },
    methods:{
        bookablesInRow(row){
            return this.bookables.slice((row -1) * this.columns, row * this.columns);
        },
        placeholdersInRow(row){
            return this.columns - this.bookablesInRow(row).length;
        },
        loadBookables(pageNum){
            this.loading = true;

            let apiUrl = '/api/bookables';
            if (pageNum !== undefined) {
                apiUrl += `?page=${pageNum}`;
            }

            const request = axios.get(apiUrl).then(response => {
                this.bookables = response.data.data;
                this.loading = false;
                this.meta = response.data.meta;
            });
        }
    },
    created(){
        this.loadBookables();
    }
};
</script>
