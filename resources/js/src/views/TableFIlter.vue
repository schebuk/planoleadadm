<template>
    <div v-if="column.type == 'string'">
        <div 
            class="tableFilters" 
            v-if="showFilterfield[column.name]" 
            :id="'filterdiv'+[column.name]"
            @focusout="handleFocusOut($event,column.name)"
            tabindex="0"
        >
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
        <div class="tableFilters" v-if="showFilterfield[column.name]" 
        :id="'filterdiv'+[column.name]"
        @focusout="handleFocusOut($event,column.name)"
        tabindex="0">
            <v-container class="grey lighten-5">
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
            </v-container>
        </div>
    </div>
    <div v-else-if="column.type == 'bool'">
        <div class="tableFilters" v-if="showFilterfield[column.name]" 
        :id="'filterdiv'+[column.name]"
        @focusout="handleFocusOut($event,column.name)"
        tabindex="0">
            <v-row no-gutters>
                <v-col
                    class="d-inline-flex pa-2"
                    cols="12"
                    sm="12"
                >    
                <v-radio-group 
                    v-model="tableData.search"
                    @change="setSearchField(column.name)">
                    <v-radio
                      label="Deactive"
                      :value="0"
                    ></v-radio>
                    <v-radio
                      label="Active"
                      :value="1"
                    ></v-radio>
                </v-radio-group>      
                </v-col>
            </v-row>
        </div>

    </div>
    <div v-else-if="column.type == 'date'">
        <div class="tableFilters" v-if="showFilterfield[column.name]" 
        :id="'filterdiv'+[column.name]"
        tabindex="0"
        @focusout="handleFocusOut($event,column.name)">
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
                    <v-datetime-picker 
                        placeholder="Search"                     
                        v-model="tableData.search"
                        solo
                        :date-picker-props="dateProps"
                        :time-picker-props="timeProps"
                        time-format="HH:mm"
                        no-title
                        :disabledDates="disabledDates"
                        dateIcon="mdiCalendarRange"
                        timeIcon="mdiClockOutline "
                        @change="setSearchField(column.name)"
                        @input="setSearchField(column.name)"
                    ></v-datetime-picker>
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
                        
                        <v-datetime-picker 
                        placeholder="Search"                     
                            v-model="tableData.search2"
                            solo
                            :date-picker-props="dateProps"
                            :time-picker-props="timeProps"
                            time-format="HH:mm"
                            no-title
                            :disabledDates="disabledDates"
                            dateIcon="mdiCalendarRange"
                            timeIcon="mdiClockOutline "
                            @change="setSearchField(column.name)"
                            @input="setSearchField(column.name)"
                        ></v-datetime-picker>
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

    import {
            mdiCalendarRange,
            mdiClockOutline,
        } from '@mdi/js'
    export default {
        emits: ['setSearchField','getUsers'],
        props: ['showFilterfield','column','tableData'],
        data() {
            let searchTypeItensString = ['contains','start','end','equal','notequal','greater','greaterequal','lesser','lesserequal'];
            let searchTypeItensData = ['greater','greaterequal','lesser','lesserequal'];
            let searchTypeItensNumber = ['contains','start','end','equal','notequal','greater','greaterequal','lesser','lesserequal'];
            let searchTypeItensBool = ['equal'];
            let searchOperator = ['AND','OR']
            let menu = false;
            if (this.column.type != 'string' || this.column.type != 'number'){
                if (this.column.type == 'bool'){
                    this.tableData.searchType='lesser'
                }
                else if (this.column.type == 'date'){
                    this.tableData.searchType='greater'
                    this.tableData.searchType2='greater'
                }
                else{                    
                    this.tableData.searchType='contains'
                }
            }
            return{
                searchTypeItensString,
                searchTypeItensData,
                searchTypeItensNumber,
                searchTypeItensBool,
                searchOperator,
                mdiCalendarRange,
                mdiClockOutline,
                menu,
                isShown: false,
                date_start: null,
                date_end: null,
                textFieldProps: {
                    prependIcon: "event"
                },
                dateProps: {
                    headerColor: "blue"
                },
                timeProps: {
                    format: "24hr"
                },
                disabledDates: {
                    from: new Date()
                }
            }
        },
        methods: {
            setSearchField(searchField){
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
                this.menu = false; 
                setSearchField(column);
            },
            getUsers(){
                this.$emit('getUsers')
            },
            handleFocusOut(evt,column){
                if (!evt.currentTarget.contains(evt.relatedTarget)) {
                    if(evt.relatedTarget){
                        if (!evt.relatedTarget.classList.contains('v-dialog')){
                            this.showFilterfield[column]=false;
                        }
                    }
                    else{
                        this.showFilterfield[column]=false;
                    }
                }
            },
        }
    }
</script>