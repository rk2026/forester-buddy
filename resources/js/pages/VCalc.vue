<template>
    <v-container fluid>
        <v-row>
            <v-col cols="6">
                <v-file-input
                    filled
                    accept=".csv"
                    v-model="csvFile"
                    label="Upload CSV"
                    placeholder="Please upload your chapan data here..."
                    @change="onFileSelect"
                ></v-file-input>
            </v-col>
            <v-col cols="6">
                <v-btn color="success" @click="downloadCalculatedCSV">Download Calculated CSV</v-btn>
            </v-col>
        </v-row>
        <v-card>
            <v-data-table
            :items="csvData"
            :headers="headers">
                <template v-slot:item.dbh="{ item }">
                    {{ item.a * item.b}}
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>

export default {
    name: "VCalc",
    data() {
        return {
            csvFile: null,
            csvData:[],
            headers:[
                {text:'SN', value: 'sn'},
                {text:'Scientific Name', value: 'scientific_name'},
                {text:'Local Name', value: 'local_name'},
                {text:'a', value: 'a'},
                {text:'b', value: 'b'},
                {text:'c', value: 'c'},
                {text:'a1', value: 'a1'},
                {text:'b1', value: 'b1'},
                {text:'s', value: 's'},
                {text:'m', value: 'm'},
                {text:'bg', value: 'bg'},
                {text:'dbh', value: 'dbh'},
            ]
        }
    },
    methods: {
        onFileSelect() {
            var temp=this;
            if (this.csvFile) {
                let data = this.$papa.parse(this.csvFile, {
                    header: true,
                    complete: function (results) {
                        temp.csvData=results.data;
                    }
                });
            }
        },
        downloadCalculatedCSV() {
            var temp=this;
            this.$papa.download(this.$papa.unparse(temp.csvData),"Calculated CSV")
        }
    }
}
</script>

<style scoped>

</style>
