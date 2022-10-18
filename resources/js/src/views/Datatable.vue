<template>
    <v-simple-table>
        <thead>
            <tr>
                <th v-for="column in columns" :key="column.name" 
                    :style="'width:'+column.width+';'+'cursor:pointer;'">
                        <a href="javascript:void(0);" @click="$emit('sort', column.name)" style="text-decoration:none; color:black;
                        text-transform: capitalize;">
                            {{column.label}}
                            <v-icon wi v-text="mdiSort" v-if="sortOrders[column.name] == 0"></v-icon>
                            <v-icon wi v-text="mdiSortAlphabeticalAscending" v-else-if="sortOrders[column.name] > 0"></v-icon>
                            <v-icon v-text="mdiSortAlphabeticalDescending" v-else></v-icon>

                            
                        </a>
                        <v-icon 
                            v-text="mdiFilter" 
                            style="float:right;"
                            @click="$emit('showFilter', column.name)"
                        ></v-icon>
                </th>
                <th></th>
            </tr>
        </thead>
        <slot></slot>
    </v-simple-table>
</template>

<script>
    import {
        mdiFilter,
        mdiSort,
        mdiSortAlphabeticalAscending ,
        mdiSortAlphabeticalDescending ,
    } from '@mdi/js'
    export default{
        setup() {
            return {
                mdiFilter,
                mdiSort,
                mdiSortAlphabeticalAscending ,
                mdiSortAlphabeticalDescending ,
            }
        },
        props:['columns','sortKey', 'sortOrders']
    }
</script>