<template>
    <div v-if="column.type == 'string'">
        <div class="tableFilters" v-if="showFilterfield[column.name]">
            <v-container class="grey lighten-5"></v-container>
                <v-row no-gutters>      
                    <h3>Filter by {{column.name}}</h3>
                </v-row>
                
                <v-row no-gutters>
                    <v-col
                        class="d-inline-flex pa-2"
                        cols="6"
                        sm="6"
                    >          
                        <v-text-field
                            v-model="tableData.search"
                            solo
                            placeholder="Search"
                            @keyup="setSearchField(column.name)"
                            hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-inline-flex pa-2"
                        cols="6"
                        sm="6"
                    >    
                        <v-select
                            :items="searchTypeItensString"
                            label="Search Type"
                            v-model="tableData.searchType"
                            solo
                            @change="getUsers"
                        ></v-select>
                    </v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col
                        class="d-inline-flex pa-2"
                        cols="6"
                        sm="6"
                    >     
                        <v-select
                            :items="searchOperator"
                            label="Search Type"
                            v-model="tableData.operator"solo
                            @change="getUsers"
                        ></v-select>
                    </v-col> 
                </v-row>
                <v-row no-gutters>
                    <v-col
                        class="d-inline-flex pa-2"
                        cols="6"
                        sm="6"
                    >          
                        <v-text-field
                            v-model="tableData.search2"
                            solo
                            placeholder="Search"
                            @keyup="setSearchField(column.name)"
                            hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-inline-flex pa-2"
                        cols="6"
                        sm="6"
                    >     
                        <v-select
                        :items="searchTypeItensString"
                        label="Search Type"
                        v-model="tableData.searchType2"
                        solo
                        @change="getUsers"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </div>
    <div v-else-if="column.type == 'number'">
        <div class="tableFilters" v-if="showFilterfield[column.name]"><v-container class="grey lighten-5"></v-container>
            <v-row no-gutters>      
                <h3>Filter by {{column.name}}</h3>
            </v-row>
            
            <v-row no-gutters>
                <v-col
                    class="d-inline-flex pa-2"
                    cols="6"
                    sm="6"
                >          
                    <v-text-field
                        v-model="tableData.search"
                        solo
                        placeholder="Search"
                        type="number"
                        @keyup="setSearchField(column.name)"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col
                    class="d-inline-flex pa-2"
                    cols="6"
                    sm="6"
                >    
                    <v-select
                        :items="searchTypeItensString"
                        label="Search Type"
                        v-model="tableData.searchType"
                        solo
                        @change="getUsers"
                    ></v-select>
                </v-col>
            </v-row>
            <v-row no-gutters>
                <v-col
                    class="d-inline-flex pa-2"
                    cols="6"
                    sm="6"
                >     
                    <v-select
                        :items="searchOperator"
                        label="Search Type"
                        v-model="tableData.operator"solo
                        @change="getUsers"
                    ></v-select>
                </v-col> 
            </v-row>
            <v-row no-gutters>
                <v-col
                    class="d-inline-flex pa-2"
                    cols="6"
                    sm="6"
                >          
                    <v-text-field
                        v-model="tableData.search2"
                        solo
                        placeholder="Search"
                        type="number"
                        @keyup="setSearchField(column.name)"
                        hide-details
                    ></v-text-field>
                </v-col>
                <v-col
                    class="d-inline-flex pa-2"
                    cols="6"
                    sm="6"
                >     
                    <v-select
                    :items="searchTypeItensString"
                    label="Search Type"
                    v-model="tableData.searchType2"
                    solo
                    @change="getUsers"
                    ></v-select>
                </v-col>
            </v-row>
        </v-container></div>

    </div>
    <div v-else-if="column.type == 'bool'">
        <div class="tableFilters" v-if="showFilterfield[column.name]">
            <v-row no-gutters>
                <v-col
                    class="d-inline-flex pa-2"
                    cols="12"
                    sm="12"
                >          
                    <v-text-field
                        v-model="tableData.search"
                        solo
                        placeholder="Search"
                        type="number"
                        @keyup="setSearchField(column.name)"
                        @input="setSearchField(column.name)"
                        hide-details
                    ></v-text-field>
                </v-col>
            </v-row>
        </div>

    </div>
    <div v-else-if="column.type == 'date'">
        <div class="tableFilters" v-if="showFilterfield[column.name]">
            <v-container class="grey lighten-5">
                <v-row no-gutters>      
                    <h3>Filter by {{column.name}}</h3>
                </v-row>
                
                <v-row no-gutters>
                    <v-col
                    cols="12"
                    sm="6"
                    md="4"
                    >
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="true"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                        @change="setSearchField(column.name)"
                        @input="setSearchField(column.name)"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            readonly                            
                            v-model="tableData.search"
                            solo
                            placeholder="Search"
                            @change="setSearchField(column.name)"
                            @input="setSearchField(column.name)"
                            hide-details
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="tableData.search"
                            no-title
                            scrollable
                            @click="clickDataPicker(column.name)"
                        >
                        </v-date-picker>
                    </v-menu>
                    </v-col>
                    <v-col
                        class="d-inline-flex pa-2"
                        cols="6"
                        sm="6"
                    >    
                        <v-select
                            :items="searchTypeItensData"
                            label="Search Type"
                            v-model="tableData.searchType"
                            solo
                            @change="getUsers"
                        ></v-select>
                    </v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col
                        class="d-inline-flex pa-2"
                        cols="6"
                        sm="6"
                    >     
                        <v-select
                            :items="searchOperator"
                            label="Search Type"
                            v-model="tableData.operator"solo
                            @change="getUsers"
                        ></v-select>
                    </v-col> 
                </v-row>
                <v-row no-gutters>
                    <v-col
                    cols="12"
                    sm="6"
                    md="4"
                    >
                    <v-menu
                        ref="menu2"
                        v-model="menu2"
                        :close-on-content-click="true"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                        @change="setSearchField(column.name)"
                        @input="setSearchField(column.name)"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            readonly                            
                            v-model="tableData.search2"
                            solo
                            placeholder="Search"
                            @change="setSearchField(column.name)"
                            @input="setSearchField(column.name)"
                            hide-details
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="tableData.search2"
                            no-title
                            scrollable
                            @click="clickDataPicker(column.name)"
                        >
                        </v-date-picker>
                    </v-menu>
                    </v-col>
                    <v-col
                        class="d-inline-flex pa-2"
                        cols="6"
                        sm="6"
                    >     
                        <v-select
                        :items="searchTypeItensData"
                        label="Search Type"
                        v-model="tableData.searchType2"
                        solo
                        @change="getUsers"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </div>
        </div>
    </div>
</template>

<script>

    export default {
        emits: ['setSearchField','getUsers'],
        props: ['showFilterfield','column','tableData'],
        data() {
            let searchTypeItensString = ['contains','start','end','equal','notequal','greater','greaterequal','lesser','lesserequal'];
            let searchTypeItensData = ['equal','notequal','greater','greaterequal','lesser','lesserequal'];
            let searchTypeItensNumber = ['contains','start','end','equal','notequal','greater','greaterequal','lesser','lesserequal'];
            let searchTypeItensBool = ['equal'];
            let searchOperator = ['AND','OR']
            let menu = false;
            if (this.column.type != 'string' || this.column.type != 'number'){
                if (this.column.type != 'bool'){
                    this.tableData.searchType='equal'
                }
                else{
                    this.tableData.searchType='lesser'
                }
            }
            return{
                searchTypeItensString,
                searchTypeItensData,
                searchTypeItensNumber,
                searchTypeItensBool,
                searchOperator,
                menu
            }
        },
        methods: {
            setSearchField(searchField){
                console.log(searchField)
                this.$emit('setSearchField', {
                    field:searchField, 
                    search:this.tableData.search,
                    type:this.tableData.searchType,
                    operator:this.tableData.operator,
                    type2:this.tableData.searchType2, 
                    search2:this.tableData.search2,
                })
            },
            clickDataPicker(column){
                console.log(123)
                this.menu = false; 
                setSearchField(column);
            },
            getUsers(){
                this.$emit('getUsers')
            }
        }
    }
</script>