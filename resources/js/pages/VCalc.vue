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
                    {{ item.a * item.b }}
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>
import axios from 'axios'

export default {
    name: "VCalc",
    data() {
        return {
            species: [],
            csvFile: null,
            csvData: [],
            headers: [
                {text: 'Chapan No.', value: 'chapan_no'},
                {text: 'Species Code', value: 'species_id'},
                {text: 'Species (Scientific Name)', value: 'scientific_name'},
                {text: 'Species (Local Name)', value: 'local_name'},
                {text: 'Latitude', value: 'latitude'},
                {text: 'Longitude', value: 'longitude'},
                {text: 'Girth(cm)', value: 'girth_cm'},
                {text: 'Height(m)', value: 'height_m'},
                {text: 'Class', value: 'class'},
                {text: 'Remarks', value: 'remarks'},
                {text: 'Tree Count', value: 'tree_count'},
                {text: 'Stem Volume (m3)', value: 'stem_volume'},
                {text: 'Branch Ratio', value: 'branch_ratio'},
                {text: 'Branch Volume(m3)', value: 'branch_volume'},
                {text: 'Tree Volume(m3)', value: 'tree_volume'},
                {text: '10 cm Top Dia. Ratio', value: 'top_dia_ratio'},
                {text: '10 cm Top Volume (m3)', value: 'top_volume'},
                {text: 'Gross Timber Volume (m3)', value: 'gross_timber_volume'},
                {text: 'Net Volume (m3)', value: 'net_volume_m3'},
                {text: 'Net Volume (cft)', value: 'net_volume_cft'},
                {text: 'Firewood (m3)', value: 'firewood'},
                {text: 'Count of Chatta', value: 'chatta_count'},
                {text: 'Dia. Class', value: 'dia_class'},
                {text: 'Dia. From', value: 'dia_from'},
                {text: 'Dia. To', value: 'dia_to'},
            ]
        }
    },
    methods: {
        onFileSelect() {
            var temp = this;
            if (this.csvFile) {
                this.$papa.parse(this.csvFile, {
                    header: true,
                    complete: function (results) {
                        temp.csvData = results.data;
                        temp.calculateValues();
                    }
                });
            }
        },
        downloadCalculatedCSV() {
            var temp = this;
            this.$papa.download(this.$papa.unparse(temp.csvData), "Calculated CSV")
        },
        calculateValues() {
            var temp = this;
            temp.csvData.forEach(function (item) {
                let species = temp.species.find(function (species) {
                    return parseInt(species.species_id) === parseInt(item.species_id);
                });
                item.scientific_name = species.scientific_name;
                item.local_name = species.local_name;
                item.tree_count = 1;
                let dbh = parseFloat(item.girth_cm) / Math.PI;
                item.stem_volume = (Math.exp(parseFloat(species.a) + parseFloat(species.b) * Math.log(dbh)+parseFloat(species.c)*Math.log(parseFloat(item.height_m))))/1000;
                /*item.branch_ratio=item.branch_ratio.trim();
                item.branch_volume=item.branch_volume.trim();
                item.tree_volume=item.tree_volume.trim();
                item.top_dia_ratio=item.top_dia_ratio.trim();
                item.top_volume=item.top_volume.trim();
                item.gross_timber_volume=item.gross_timber_volume.trim();
                item.net_volume_m3=item.net_volume_m3.trim();
                item.net_volume_cft=item.net_volume_cft.trim();
                item.firewood=item.firewood.trim();
                item.chatta_count=item.chatta_count.trim();
                item.dia_class=item.dia_class.trim();
                item.dia_from=item.dia_from.trim();
                item.dia_to=item.dia_to.trim();*/
            });
        }
    },
    mounted() {
        axios.get('/api/species').then(response => {
            this.species = response.data.data
        })
    }
}
</script>

<style scoped>

</style>
