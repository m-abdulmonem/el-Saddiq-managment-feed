<template>
    <select name='client_id' class="form-control client" id="client">
        <option v-for="client in clients" v-text="client.text"
                :value="client.id"
                :data-credit="client.credit"
                :data-remaining="client.remaining">{{ client.text }}</option>
    </select>
</template>

<script>
    import select2 from "select2";
    export default {
        name: "Select2Component",
        data(){
            return {
                clients: []
            }
        },
        mounted() {
            this.getClients();
            this.initSelect2();
            this.select()
        },
        methods: {
            initSelect2 (){
                $("#client").select2()
            },
            select (){

                $("#client").on("select2:select", function (e) {
                    // const limit = $("#client option:selected").attr("data-credit");
                    const remaining = $("#client option:selected").attr("data-remaining");
                    if (parseFloat(remaining) <= 0){
                        swal("تنبية, غير مسموح إصدار أفواتير لهذا العميل الى حين سداد مبلغ الائتمان ",{
                            icon: "warning",
                            timers: 3000
                        })
                    }
                    $("#credit").val(remaining);
                    // $("#remainingCredit").val(limit);
                });
            },
            getClients (){
                axios.get("/ajax/client/names")
                    .then((response) => this.clients = response.data[0])
                    .catch(error => {})
            }
        }
    }
</script>

<style scoped>

</style>
