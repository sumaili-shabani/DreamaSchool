<template>
    <div>
        <v-card flat>
            <v-form ref="form" lazy-validation>

                <v-card-text>

                    <v-layout row wrap>
                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <img :style="{ height: style.height }" id="output" />
                            </div>
                        </v-flex>
                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">

                                <!-- debit -->
                                <div class="col-lg-12">
                                    <div class="form-group">

                                        <div class="image-upload">
                                            <input type="file" id="photo_input" @change="onImageChange" required />
                                            <div class="image-uploads">
                                                <img :src="`${baseURL}/vuetheme/assets/img/icons/upload.svg`" alt="img">
                                                <h4>Drag and drop a file to upload</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- fin -->

                            </div>
                        </v-flex>

                        <v-flex xs12 sm12 md5 lg5></v-flex>

                        <v-flex xs12 sm12 md4 lg4>
                            <div class="mr-1">

                                <v-btn color="primary" dark :loading="loading" @click="insertPhoto">
                                    {{ edit ? "Modifier Ma photo" : "Ajouter la photo" }}
                                </v-btn>

                            </div>
                        </v-flex>

                        <v-flex xs12 sm12 md3 lg3></v-flex>
                    </v-layout>



                </v-card-text>

            </v-form>
        </v-card>
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                agentId: "",
            },
            image: "",
            loading: false,
            style: {
                height: "0px",
            },
        };
    },

    created() {
        this.editData(this.userData.id);
    },
    computed: {
        ...mapGetters(["userList", "isloading"]),
    },

    methods: {
        ...mapActions(["getUser"]),
        editData(id) {
            if (id != '') {
                this.svData.agentId = id;
            }
            else {
                this.svData.agentId = 0;
            }
        },

        insertPhoto() {
            this.updatePhoto();
        },
        onImageChange(e) {
            this.image = e.target.files[0];
            let output = document.getElementById("output");
            output.src = URL.createObjectURL(e.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src); // free memory
                this.style.height = "140px"; // free memory
            };
        },

        updatePhoto() {
            const config = {
                headers: { "content-type": "multipart/form-data" },
            };

            let formData = new FormData();
            formData.append("data", JSON.stringify(this.svData));
            formData.append("image", this.image);

            axios
                .post(`${this.apiBaseURL}/edit_photo`, formData, config)
                .then(({ data }) => {
                    this.image = "";
                    this.showMsg(data.data);

                    // setTimeout(() => window.location.reload(), 2000);
                    document.getElementById("photo_input").value = "";
                    document.getElementById("output").src = "";
                })
                .catch((err) => this.svErr());
        },

        showoneImageTug() {
            var id = this.svData.agentId;
            var img = this.image;
            console.log("id_user:" + id + " image:" + img);
        },
    },
};
</script>
