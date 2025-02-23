<template>

    <div>

        <!-- contenu -->

        <!-- Fin contenu -->

        <!-- debit -->
        <div class="page-header">
            <div class="page-title">
                <h4>Ponctualité</h4>
                <h6>Gérez les opérations</h6>
            </div>
            <div class="page-btn">
                <a href="javascript:void(0);" @click="showModal" class="btn btn-added" style="color: white;">
                    <img :src="`${baseURL}/vuetheme/assets/img/icons/plus.svg`" class="me-2" alt="img" />
                    Ajouter
                </a>
            </div>
        </div>

        <!-- card -->
        <div class="card">
            <div class="card-body">
                <!-- Entete -->
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">


                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn :loading="loading" fab text small
                                            @click="getCalendarPresence($route.params.codeInscription)"
                                            class="btn btn-warning" style="margin-right: 6px;">
                                            <v-icon>autorenew</v-icon>
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Initialiser</span>
                            </v-tooltip>


                        </div>
                        <div class="search-input">



                        </div>
                    </div>
                    <!-- Excel, pdf, print -->
                    <!-- <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                        :src="`${baseURL}/vuetheme/assets/img/icons/pdf.svg`" alt="img" /></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                        :src="`${baseURL}/vuetheme/assets/img/icons/excel.svg`" alt="img" /></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                        :src="`${baseURL}/vuetheme/assets/img/icons/printer.svg`" alt="img" /></a>
                            </li>
                        </ul>
                    </div> -->
                    <!-- Fin Excel, pdf, print -->
                </div>
                <!-- Fin Entete -->

                <!-- calendrier -->
                <!-- codeInscription : {{ codeInscription }} -->
                <v-app>



                    <div>
                        <v-sheet tile height="54" class="d-flex">
                            <v-btn icon class="ma-2" @click="$refs.calendar.prev()">
                                <v-icon>mdi-chevron-left</v-icon>
                            </v-btn>
                            <v-select v-model="type" :items="types" dense outlined hide-details class="ma-2"
                                label="type"></v-select>
                            <v-select v-model="mode" :items="modes" dense outlined hide-details
                                label="event-overlap-mode" class="ma-2"></v-select>
                            <v-select v-model="weekday" :items="weekdays" dense outlined hide-details label="weekdays"
                                class="ma-2"></v-select>
                            <v-spacer></v-spacer>
                            <v-btn icon class="ma-2" @click="$refs.calendar.next()">
                                <v-icon>mdi-chevron-right</v-icon>
                            </v-btn>
                        </v-sheet>
                        <!-- <v-sheet height="600">
                             <v-calendar ref="calendar" v-model="value" :weekdays="weekday" :type="type"
                                :events="events2" :event-overlap-mode="mode" :event-overlap-threshold="30"
                                :event-color="getEventColor" @change="getEvents"></v-calendar>
                        </v-sheet> -->

                        <v-sheet height="600">
                            <v-calendar ref="calendar" v-model="focus" color="primary" :events="events2"
                                :event-color="getEventColor" :type="type" @click:event="showEvent" @click:more="viewDay"
                                @click:date="viewDay" @change="getEvents"></v-calendar>
                            <v-menu v-model="selectedOpen" :close-on-content-click="false" :activator="selectedElement"
                                offset-x>
                                <v-card color="grey lighten-4" min-width="350px" flat>
                                    <v-toolbar :color="selectedEvent.color" dark>
                                        <v-avatar size="avatarSize" color="red">
                                            <img style="border-radius: 50px; width: 50px; height: 50px" :src="selectedEvent.photoEleve == null
                                                ? `${baseURL}/images/avatar.png`
                                                : `${baseURL}/images/` + selectedEvent.photoEleve
                                                " />
                                        </v-avatar>
                                        <v-toolbar-title>{{ selectedEvent.nomEleve + " - " + selectedEvent.name
                                            }}</v-toolbar-title>
                                        <v-spacer></v-spacer>
                                        <v-btn icon>
                                            <v-icon>mdi-heart</v-icon>
                                        </v-btn>
                                        <v-btn icon>
                                            <v-icon>mdi-dots-vertical</v-icon>
                                        </v-btn>
                                    </v-toolbar>
                                    <v-card-text>
                                        <span v-html="selectedEvent.details"></span>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn text color="secondary" @click="selectedOpen = false">
                                            Cancel
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-menu>
                        </v-sheet>
                    </div>
                </v-app>

                <!-- fin calendrier -->
                <!-- pagination -->

                <!-- fin pagination -->
            </div>
        </div>
        <!-- fin card -->

    </div>




</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
    components: {},
    data() {
        return {
            title: "Pays component",
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            codeInscription: "",
            svData: {
                id: "",
                nomPays: "",
            },
            fetchData: null,
            titreModal: "",

            events2: [
                {
                    name: 'Event 1',
                    start: '2024-06-01',
                    timed: false,
                    color: 'green',
                },
                {
                    name: 'Event 2',
                    start: '2024-06-05',
                    end: '2024-06-07',
                    color: 'yellow darken-3',
                },
                {
                    name: 'Event 3',
                    start: '2024-06-09T08:00:00',
                    end: '2024-06-09T10:00:00',
                    timed: true,
                    color: 'red',
                },
            ],
            focus: '',
            type: 'month',
            types: ['month', 'week', 'day', '4day'],
            mode: 'stack',
            modes: ['stack', 'column'],
            weekday: [0, 1, 2, 3, 4, 5, 6],
            weekdays: [
                { text: 'Sun - Sat', value: [0, 1, 2, 3, 4, 5, 6] },
                { text: 'Mon - Sun', value: [1, 2, 3, 4, 5, 6, 0] },
                { text: 'Mon - Fri', value: [1, 2, 3, 4, 5] },
                { text: 'Mon, Wed, Fri', value: [1, 3, 5] },
            ],
            value: '',
            events: [],
            colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
            names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
            selectedEvent: {},
            selectedElement: null,
            selectedOpen: false,

        };
    },
    mounted () {
      this.$refs.calendar.checkChange()
    },
    computed: {
        ...mapGetters(["roleList", "isloading"]),
    },
    methods: {
        ...mapActions(["getRole"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout pays ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de " + item.nomPays;
            } else {
                this.titleComponent = "Ajout pays ";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_pays?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_pays`,
                    JSON.stringify(this.svData)
                )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.onPageChange();

                        this.dialog = false;
                    })
                    .catch((err) => {
                        this.isLoading(false);
                    });
            }
        },
        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_pays/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;

                    donnees.map((item) => {
                        this.titleComponent = "modification de " + item.nomPays;
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_pays/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        //calendar
        getCalendarPresence(codeInscription) {
            this.isLoading(true);
            this.editOrFetch(`${this.apiBaseURL}/fetch_calendrier_presence_eleve/${codeInscription}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.events2 = donnees;
                    this.isLoading(false);
                }
            );
        },

        getEvents({ start, end }) {
            const events = []

            const min = new Date(`${start.date}T00:00:00`)
            const max = new Date(`${end.date}T23:59:59`)
            const days = (max.getTime() - min.getTime()) / 86400000
            const eventCount = this.rnd(days, days + 20)

            for (let i = 0; i < eventCount; i++) {
                const allDay = this.rnd(0, 3) === 0
                const firstTimestamp = this.rnd(min.getTime(), max.getTime())
                const first = new Date(firstTimestamp - (firstTimestamp % 900000))
                const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
                const second = new Date(first.getTime() + secondTimestamp)

                events.push({
                    name: this.names[this.rnd(0, this.names.length - 1)],
                    start: first,
                    end: second,
                    color: this.colors[this.rnd(0, this.colors.length - 1)],
                    timed: !allDay,
                })
            }

            this.events = events
        },
        getEventColor(event) {
            return event.color
        },
        rnd(a, b) {
            return Math.floor((b - a + 1) * Math.random()) + a
        },

        //debit
        viewDay({ date }) {
            this.focus = date
            this.type = 'month'
        },
        getEventColor(event) {
            return event.color
        },
        setToday() {
            this.focus = ''
        },
        prev() {
            this.$refs.calendar.prev()
        },
        next() {
            this.$refs.calendar.next()
        },
        showEvent({ nativeEvent, event }) {
            const open = () => {
                this.selectedEvent = event
                this.selectedElement = nativeEvent.target
                requestAnimationFrame(() => requestAnimationFrame(() => this.selectedOpen = true))
            }

            if (this.selectedOpen) {
                this.selectedOpen = false
                requestAnimationFrame(() => requestAnimationFrame(() => open()))
            } else {
                open()
            }

            nativeEvent.stopPropagation()
        },


    },
    created() {
        this.codeInscription = this.$route.params.codeInscription;
        this.getCalendarPresence(this.$route.params.codeInscription);
        this.onPageChange();
    },
};
</script>
