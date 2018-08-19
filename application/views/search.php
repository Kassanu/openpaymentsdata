<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Search</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
<div id="app">
<search ref="search"></search>
</div>

<template id="search-template">
    <div>
        <search-form :search="search" @toggle-overlay="toggleOverlay" @toggle-message="setOverlayMessage"></search-form>
        <pagination :search="search" :page="page" :limit="limit" :total-records-found="totalRecordsFound"></pagination>
        <search-results-table :items="items"></search-results-table>
        <pagination :search="search" :page="page" :limit="limit" :total-records-found="totalRecordsFound"></pagination>
        <div v-if="overlay" id="loading-overlay" class="d-flex flex-column justify-content-center align-content-center align-items-center" style="position: fixed; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.6); z-index: 10000;">
            <div class="lds-roller mb-3"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            {{overlayMessage}}
        </div>
    </div>
</template>

<template id="search-form-template">
<div class="d-flex mb-3">
    <div class="mr-3" style="flex: 1 1 0;">
        <form action="/search" method="get" autocomplete="off">
            <div class="input-group" style="flex-wrap: inherit;">
                <v-autocomplete
                    :start-value="search"
                    :remote="true"
                    :remote-url="'/api/v1/payment/typeahead'"
                    :return-amount="10"
                    filter-key="physician_first_name"
                    :min-length="2" 
                    :item-component="'autocomplete-item-physician-name'"
                    :get-label="item => item.physician_first_name + ' ' + item.physician_last_name"
                    name="search" 
                    placeholder="Enter Physician's name"
                >
                </v-autocomplete>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" id="search-submit-button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-cog"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="javascript:void(0)" @click="fetchData">Re-fetch Data</a>
            <a class="dropdown-item" href="javascript:void(0)" @click="exportData">Export to XLS</a>
        </div>
    </div>
    <form id="exportForm" target="exportFrame" method="post" action="/api/v1/payment/export" style="visibility: hidden; position: absolute;">
        <input type="hidden" name="search" :value="search">
    </form>
    <iframe id="exportFrame" name="exportFrame" style="visibility: hidden; position: absolute;"></iframe>
</div>
</template>

<template id="autocomplete-template">
    <div class="input-group">
        <input 
            class="form-control"
            type="text" 
            class="SearchInput" 
            :placeholder="placeholder"
            :name="name"
            :value="value"
            @input="inputChange"
            @blur="blur" 
            @focus="focus"
            @keyup.enter.prevent="keyEnter" 
            @keydown.up.prevent="keyUp" 
            @keydown.down.prevent="keyDown"
        > 
        <div class="dropdown-menu dropdown-menu-scrollable w-100" v-bind:class="{ show: show }">
            <div :is="itemComponent" v-for="item, i in filtered" :item="item" :key="item.id" @click="onClickItem(item)" :class="{'active': i === cursor}" @mouseover="cursor = i"></div>
        </div>
  </div>
</template>

<template id="autocomplete-item-default-template">
  <div class="dropdown-item" @click="$emit('click', item)">{{item}}</div>
</template>

<template id="autocomplete-item-physician-name-template">
  <div class="dropdown-item" @click="$emit('click', item)">{{item.physician_first_name}} {{item.physician_last_name}}</div>
</template>

<template id="search-results-table-template">
    <table class="table table-stripped table-hover my-3">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in items" :item="item" :key="item.id">
                <td>{{item.physician_first_name}}</td>
                <td>{{item.physician_last_name}}</td>
            </tr>
        </tbody>
    </table>
</template>

<template id="pagination-template">
    <div class="d-flex justify-content-between align-items-center">
        <div>Showing <span class="text-primary font-weight-bold">{{resultsFrom}}</span>-<span class="text-primary font-weight-bold">{{resultsTo}}</span> of <span class="text-primary font-weight-bold">{{totalRecordsFound}}</span> results</div>
        <div v-if="maxPages > 1">
            <div class="input-group">
                <div class="input-group-prepend" v-if="page > 1">
                    <a v-bind:href="prevLink" class="btn btn-primary">Prev</a>
                </div>
                <select class="form-control" @change="changePage" :value="page">
                    <option v-for="index in maxPages" :key="index">{{index}}</option>
                </select>
                <div class="input-group-append" v-if="page < maxPages">
                    <a v-bind:href="nextLink" class="btn btn-primary">Next</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="/assets/js/lodash.min.js" defer></script>
<script src="/assets/js/search.js" defer></script>
</body>

</html>
