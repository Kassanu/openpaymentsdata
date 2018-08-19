Vue.component('search', {
    template: '#search-template',
    data: function() {
        return {
            search: "",
            limit: 100,
            page:1,
            totalRecordsFound: 0,
            items: [],
            overlay: false,
            overlayMessage: "This will take a while..."
        }
    },
    computed: {

    },
    methods: {
        loadUrlParameters: function() {
            let params = (new URL(document.location)).searchParams;
            this.search = params.get("search") || this.search;
            this.limit = parseInt(params.get("limit")) || this.limit;
            this.page = parseInt(params.get("page")) || this.page;
        },
        getPayments: function() {
            this.setOverlayMessage("Loading search results");
            this.toggleOverlay(true);
            axios.get('http://localhost/api/v1/payment', {
                params: {
                    search: this.search,
                    limit: this.limit,
                    page: this.page
                }
            })
            .then(response => { 
                console.log(response.data);
                this.items = response.data.results;
                this.totalRecordsFound = parseInt(response.data.total);
                this.$nextTick(() => {
                    this.toggleOverlay(false);
                });
            })
            .catch(error => {
                this.toggleOverlay(false);  
                console.log(error);
            });
        },
        toggleOverlay: function(toggle) {
            this.overlay = toggle;
        },
        setOverlayMessage: function(message) {
            this.overlayMessage = message;
        }
    },
    created() {
        this.loadUrlParameters();
        this.getPayments();
    }
});

Vue.component('search-form', {
    template: '#search-form-template',
    props: {
        search: { 
            type: String, 
            required: true
        }
    },
    data: function() {
        return {

        }
    },
    computed: {

    },
    methods: {
        fetchData: function() {
            this.$emit('toggle-message', "This will take a while...");
            this.$emit('toggle-overlay', true);
            axios.post('/api/v1/payment/reseed')
            .then(response => { 
                //Noticed when fetching data from the api reloading the window as soon as the request comes back doesn't catch all data
                setTimeout(function(){ window.location = window.location.origin+'/search'; }, 10000);
            })
            .catch(error => {
                this.$emit('toggle-overlay', false);
            });
        },
        exportData: function() {
            this.$emit('toggle-message', "Generating your spreadsheet");
            this.$emit('toggle-overlay', true);
            document.getElementById("exportForm").submit();
        }
    },
    mounted() {

    }
});

Vue.component('search-results-table', {
    template: '#search-results-table-template',
    props: {
        items: { 
            type: Array, 
            required: true
        }
    },
    data: function() {
        return {

        }
    },
    computed: {

    },
    methods: {

    },
    mounted() {

    }
});

Vue.component('pagination', {
    template: '#pagination-template',
    props: {
        search: { 
            type: String, 
            required: true
        },
        page: { 
            type: Number, 
            required: true
        },
        limit: { 
            type: Number, 
            required: true
        },
        totalRecordsFound: { 
            type: Number, 
            required: true
        },
    },
    data: function() {
        return {
            
        }
    },
    computed: {
        maxPages: function () {
            return Math.ceil(this.totalRecordsFound/this.limit);
        },
        resultsFrom: function() {
            return (this.page * this.limit) - (this.limit - 1);
        },
        resultsTo: function() {
            return this.page == this.maxPages?this.totalRecordsFound:(this.page * this.limit);
        },
        prevLink: function() {
            return this.buildLink(this.page-1);
        },
        nextLink: function() {
            return this.buildLink(this.page+1);
        }        
    },
    methods: {
        buildLink: function(page) {
            let url = new URL('/search', window.location.origin);
            url.searchParams.set('page', page);
            url.searchParams.set('search', this.search);
            url.searchParams.set('limit', this.limit);
            return url;
        },
        changePage: function(e) {
            window.location = this.buildLink(e.target.value);
        }
    },
    mounted() {

    }
});

Vue.component('v-autocomplete', {
    template: '#autocomplete-template',
    props: {
        startValue: {
            type: String,
            default: ""
        },
        items: {
            type: Array,
            default: () => []
        },
        remote: {
            type: Boolean,
            default: false
        },
        remoteUrl: {
            type: String,
            default: ''
        },
        filterKey: {
            type: String,
            required: true
        },
        minLength: {
            type: Number,
            default: 3
        },
        returnAmount: {
            type: Number,
            default: 0
        },
        placeholder: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            default: ''
        },
        getLabel: {
            type: Function,
            default: item => item
        },
        itemComponent: { 
            type: String, 
            default: 'autocomplete-item-default'
        }
    },
    data: function() {
        return {
            value: "",
            listOpen: false,
            keepOpen: false,
            remoteItems: [],
            cursor: 0
        }
    },
    methods: {
        fetchItems: _.debounce(function (key, value) {
            if ( this.remote && typeof this.remoteUrl === 'string' && this.remoteUrl.length > 0) {
                axios.get(this.remoteUrl, {params: {column: key, query: value, limit: this.returnAmount}})
                .then(response =>{
                    this.remoteItems = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
            }
            else {
                this.remoteItems = [];
            }
        }, 500, {leading: false, trailing: true}),
        reset() {
            this.value = '';
        },
        hideList() {
            this.listOpen = false;
        },
        showList() {
            this.listOpen = true;
        },
        inputChange (event) {
            this.value = event.target.value;
            this.cursor = 0;
            if (this.remote && this.value.length > this.minLength) {
                this.fetchItems(this.filterKey, this.value);
            }
            else if (this.remote && this.value.length < this.minLength) {
                this.remoteItems = [];
            }

            if (this.filtered.length > 0) {
                if (this.value.toLowerCase() === this.filtered[0][this.filterKey].toLowerCase()) {
                    this.value = this.filtered[0][this.filterKey];
                }
                this.showList();
            }

            this.$emit('input', this.value);
            this.$emit('update');
        },
        focus () {
            this.$emit('focus', this.value);
            this.showList();
            this.cursor = 0;
        },
        blur () {
            this.$emit('blur', this.value);
            setTimeout( () => this.hideList(), 200);
        },
        onClickItem(item) {
            this.onSelectItem(item);
            this.$emit('item-clicked', item);
        },
        onSelectItem (item) {
            if (this.remote) {
                this.remoteItems = [];
            }
            this.value = this.getLabel(item);
            this.$emit('input', this.getLabel(item));
            this.$emit('update');
        },
        keyUp (e) {
            if (this.cursor > 0) {
                this.cursor--;
                let item = this.$el.getElementsByClassName('dropdown-item')[this.cursor];
                item.scrollIntoView(false);
            }
        },
        keyDown (e) {
            let len = this.remoteItems.length || this.filtered.length;
            if (this.cursor < len - 1) {
                this.cursor++;
                let item = this.$el.getElementsByClassName('dropdown-item')[this.cursor];
                item.scrollIntoView(false);
            }
        },
        keyEnter (e) {
            if (this.remote && this.remoteItems.length > 0) {
                this.onSelectItem(this.remoteItems[this.cursor]);
                this.hideList();
            }
            else if(!this.remote && this.filtered.length > 0) {
                this.onSelectItem(this.filtered[this.cursor]);
                this.hideList();
            }
        },
    },
    computed: {
        filtered() {

            if (this.remote === true) {
                return this.remoteItems;
            }

            if(this.value !== undefined && this.value.length >= this.minLength) {
                let filt = this.items.filter(item => {
                    if( item.hasOwnProperty(this.filterKey)  ) {
                        return item[this.filterKey]
                                .toLowerCase()
                                .indexOf(this.value.toLowerCase()) > -1;
                    } else {
                        console.error(`Seems like property you passed down ${this.filterKey} doesn't exist on object ! `);
                    }
                });
                
                if (this.value.length > 0) {
                    filt.sort((a, b) => {
                        return a[this.filterKey].toLowerCase().indexOf(this.value.toLowerCase()) < b[this.filterKey].toLowerCase().indexOf(this.value.toLowerCase());
                     });
                }

                if (this.returnAmount > 0) {
                    return filt.slice(0, this.returnAmount);
                }
                else {
                    return filt;
                }
            }

            return [];
        },
        isEmpty() {
            if( typeof this.filtered === 'undefined'  ) {
                return false;
            } else {
                return this.filtered.length < 1;
            }
        },
        hasItems () {
            if( typeof this.filtered === 'undefined'  ) {
                return false;
            } else {
                return this.remove?!!this.remoteItems.length:!!this.filtered.length;
            }
        },
        show () {
            return (this.listOpen && this.hasItems) || this.keepOpen
        }
    },
    mounted() {
        this.value = this.startValue;
    }
});

Vue.component('autocomplete-item-default', {
    props: ['item'],
    template: '#autocomplete-item-default-template'
});

Vue.component('autocomplete-item-physician-name', {
    props: ['item'],
    template: '#autocomplete-item-physician-name-template'
});

const app = new Vue({
    el: '#app'
});