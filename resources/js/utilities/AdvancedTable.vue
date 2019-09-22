<template>
  <div class="table-section">
  <div class="row" style="display:none !important;">
    <div class="col-sm-12 col-md-12 col-lg-6">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{camelCaseStr(currentFilter)}}</button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#" @click.prevent="setCurrentFilter(keys)" v-for="(value,keys) in this.filterableHeaders">{{camelCaseStr(keys)}}</a>
        </div>
      </div>
      <input type="text" class="form-control" @keyup="filterTyping" v-model.trim="currentFilterString" placeholder="Filter Data based on the column and text you wish to sort">
      </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-2">
      <button class="btn btn-primary" @click="filterData()"><i class="fas fa-search"></i> Search</button>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-2 text-center">
      <button class="btn btn-danger" @click="clearFilters()"><i class="far fa-times-circle"></i> Clear Filters</button>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-2 text-center">
      <a href="#" @click.prevent="downloadFile('xlsx')" class="btn btn-success" v-if="this.currentDownloadPath"><i class="far fa-file-excel"></i> Download as XLSX </a>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <p v-if="filterSet">Filtered entries with <strong class="font-raleway"><u>{{camelCaseStr(currentFilter)}}</u></strong> that contain <strong class="font-raleway"><u>{{currentFilterString}}</u></strong></p>
    </div>
  </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th style="cursor:pointer" @click="sortByToggle(keys)" v-for="(value,keys) in this.tableHeaders">{{camelCaseStr(keys)}} <i v-if="(keys == currentSortBy)" :class="{'fa-sort-up': (currentSortOrder == 'asc'), 'fa-sort-down': (currentSortOrder == 'desc')}"  class="float-right fas" style="line-height:inherit !important;"></i></th>
          <th colspan="3" v-if="hasActions">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="n in results.data.length">
          <td v-for="(value,key) in tableHeaders">{{ results.data[n-1][key]}}</td>
          <td v-if="results.data[n-1]['_canView']"><a :href="getviewurl(results.data[n-1].id)" class="btn btn-info btn-sm text-white"><span class="far fa-eye"></span> View</a></td>
          <td v-if="results.data[n-1]['_canEdit']"><a :href="getediturl(results.data[n-1].id)" class="btn btn-warning btn-sm"><span class="far fa-edit"></span> Edit</a></td>
          <td v-if="results.data[n-1]['_canDelete']"><button class="btn btn-danger btn-sm" @click="deleteitem(results.data[n-1].id)"><span class="far fa-trash-alt"></span> Delete</button></td>
        </tr>
      </tbody>
    </table>
    <p>Showing {{this.results.meta.from}} - {{this.results.meta.to}} of {{this.results.meta.total}} entries</p>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-end">
        <li class="page-item">
          <a class="page-link" @click.prevent="newContentFrom(getPageLink(1))" :href="this.getPageLink(1)">First Page</a>
        </li>

        <li class="page-item"><a class="page-link active" @click.prevent="newContentFrom(getPageLink(results.meta.current_page-1))" v-if="this.results.meta.current_page!=1" :href="this.getPageLink(this.results.meta.current_page-1)">{{this.results.meta.current_page-1}}</a></li>
        <li class="page-item"><a class="page-link active" @click.prevent="newContentFrom(getPageLink(results.meta.current_page))"  :href="this.getPageLink(this.results.meta.current_page)">{{this.results.meta.current_page}}</a></li>
        <li class="page-item"><a class="page-link active" @click.prevent="newContentFrom(getPageLink(results.meta.current_page+1))"  v-if="this.results.meta.current_page!=this.results.meta.last_page" :href="this.getPageLink(this.results.meta.current_page+1)">{{this.results.meta.current_page+1}}</a></li>


        <li class="page-item">
          <a class="page-link" :href="this.getPageLink(this.results.meta.last_page)" @click.prevent="newContentFrom(getPageLink(results.meta.last_page))">Last Page</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
//bigObj in this.results.data
  export default {
    props: ['resourceurl', 'viewurl' ,'editurl', 'deleteurl', 'downloadurl'],
    data: function() {
      return {
                results: { data: [], meta: {from: 0, to: 0, total: 0}, links: {prev: null,next:null}},
                currentDataPath: this.resourceurl,
                currentSortBy: 'id',
                currentSortOrder: 'asc',
                currentFilter: 'filter column',
                currentFilterString: '',
                filterSet: false,
                notFilterable: {},
                notSortable: {},
                currentDownloadPath: this.downloadurl
            };
    },
    methods: {
      fillData(data)
      {
            if(this.currentDataPath != this.resourceurl && data.data.length == 0)
            {
              Vue.toasted.error("No Results found for the selected Criteria");
              Vue.toasted.info("Loading default initial data.");
              //this.results = { data: [this.tableHeaders], meta: {from: 0, to: 0, total: 0}, links: {prev: null,next:null}};
              this.filterSet= false;
              this.newContentFrom(this.resourceurl);
            }else
            {
              this.results = data;
              if(data.data.length > 0)
              {
                this.notFilterable = data.data[0]._not_filterable;
                this.notSortable = data.data[0]._not_sortable;
              }
              else
              {
                Vue.toasted.info("No Data found");
              }
            }
      },
      filterTyping(e)
      {
        this.filterSet = false;
        if(e.keyCode == 13)
        {
          this.filterData()
        }
      },
      getediturl(id)
      {
        return this.editurl + "/" +id
      },
      getviewurl(id)
      {
        return this.viewurl + "/" +id
      },
      clearFilters()
      {
        this.filterSet = false;
        this.currentFilter = 'filter column'
        this.currentFilterString=''
      },
      filterData()
      {
        if(this.currentFilter == 'filter column')
        {
          Vue.toasted.error('Please Selet a Column to Filter')
        }
        else if(this.currentFilterString == '')
        {
          Vue.toasted.error('Please enter content in the selected column to search for')
        }else
        {
          this.filterSet = true
          this.newContentFrom(this.getPageLink(1))
        }
      },
      sortByToggle(sortKey)
      {
        return ;
        if((typeof this.notSortable === 'undefined') || !this.notSortable.includes(sortKey))
        {
          if(this.currentSortOrder == 'desc')
            this.currentSortOrder = 'asc'
          else
            this.currentSortOrder = 'desc'
          this.currentSortBy = sortKey;

          this.newContentFrom(this.getPageLink(1))
        }
        else
        {
          Vue.toasted.error('You cannot sort based on this column');
        }

      },
      getdeleteurl(id)
      {
        return this.deleteurl + "/" +id
      },
      setCurrentFilter(filterKey)
      {
        this.currentFilter = filterKey.replace('-','_');
        this.filterSet = false;
      },
      previousPageAvailable()
      {
        return (this.results.meta.current_page!=1)
      },
      getPageLink(pageNum)
      {
        if(this.filterSet)
          return this.results.meta.path+"?page="+pageNum+"&sort="+this.currentSortBy+"-"+this.currentSortOrder+"&"+this.currentFilter+"="+this.currentFilterString;
        else
          return this.results.meta.path+"?page="+pageNum+"&sort="+this.currentSortBy+"-"+this.currentSortOrder
      },
      deleteitem(id)
      {
        if(confirm('Are you sure you want to delete this? Remember: You cannot undo this action.'))
          axios.delete(this.getdeleteurl(id))
            .then((response) => {
            if(response.data.message !='')
              Vue.toasted.success(response.data.message);
              if(response.data.error !='')
                Vue.toasted.error(response.data.error);
              this.loadData();
            })
            .catch((error) => {
                console.log(error)
                Vue.toasted.error("Error Sending Request to Server");
            });
      },
      downloadFile(fileFormat)
      {
        if(this.downloadurl != '')
        {
          let finalDownloadUrl = '';
          if(this.filterSet)
            finalDownloadUrl = this.currentDownloadPath+"?sort="+this.currentSortBy+"-"+this.currentSortOrder+"&"+this.currentFilter+"="+this.currentFilterString+"&format="+fileFormat;
          else
            finalDownloadUrl = this.currentDownloadPath+"?sort="+this.currentSortBy+"-"+this.currentSortOrder+"&format="+fileFormat

            var win = window.open(finalDownloadUrl, '_blank');
            win.focus();
        }
      },
      newContentFrom(url)
      {
        this.currentDataPath = url;
        this.loadData();
      },
      loadData()
      {
        if(this.currentDataPath.toString().substring(0,5) != 'http:' && this.currentDataPath.toString().substring(0,6) != 'https:')
            this.geturl = siteUrl + this.currentDataPath
        else
            this.geturl = this.currentDataPath

        axios.get(this.geturl)
          .then((response) => {
            this.fillData(response.data)
          })
          .catch((error) => {
              console.log(error);
              Vue.toasted.error("Error Loading Data from Server");
          });
      },
    },
    computed: {
      tableHeaders: function() {
        return _.pickBy(this.results.data[0],(function(item,key) {
          return key.toString().charAt(0) != '_';
      }))
      },
      filterableHeaders: function() {
        if(typeof this.notFilterable !== 'undefined')
          return _.pickBy(this.tableHeaders,(item,key) => { return !this.notFilterable.includes(key.toString())})
        else
          return this.tableHeaders
      },
      hasActions: function() {
        var doesit = false;
        _.forOwn(this.results.data, (val,key) => {
          if(val['_canEdit'] || val['_canView'] || val['_canDelete'])
            doesit = true;
        });
        return doesit;
      },
    },
    mounted() {
      this.loadData();
      let uri = this.geturl.split('?');
      if (uri.length == 2)
      {
        let vars = uri[1].split('&');
        let getVars = {};
        let tmp = '';
        vars.forEach(function(v){
          tmp = v.split('=');
          if(tmp.length == 2)
          getVars[tmp[0]] = tmp[1];
        });
        let sorte = getVars['sort'].split('-');
        this.currentSortBy = sorte[0];
        this.currentSortOrder = sorte[1];
      }
    }
  }
</script>