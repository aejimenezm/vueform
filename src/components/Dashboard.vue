<template>
  <div class="vue-template">
    <h3>Dashboard</h3>
    <button
      @click="tableToExcel('table', 'Registros')"
      class="btn btn-dark btn-lg btn-block"
    >
      Exportar a Excel
    </button>
    <button @click="tableToPDF()" class="btn btn-dark btn-lg btn-block">
      Exportar a PDF
    </button>
    <table id="Table" ref="table" class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>Fecha de Nacimiento</th>
          <th>Direcci&oacute;n</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="registro in registros" :key="registro.id">
          <td>{{ registro.id }}</td>
          <td>{{ registro.nombres }}</td>
          <td>{{ registro.apellidos }}</td>
          <td>{{ registro.fechaNac }}</td>
          <td>{{ registro.direccion }}</td>
          <td>{{ registro.email }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
var url = "http://localhost/vueform/db/backend.php";
import axios from "axios";
import jsPDF from "jspdf";
export default {
  data() {
    return {
      uri: "data:application/vnd.ms-excel;base64,",
      template:
        '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
      base64: function (s) {
        return window.btoa(unescape(encodeURIComponent(s)));
      },
      format: function (s, c) {
        return s.replace(/{(\w+)}/g, function (m, p) {
          return c[p];
        });
      },
      registros: [],
      registro: {
        id: null,
        nombres: null,
        apellidos: null,
        fechaNac: null,
        direccion: null,
        email: null,
      },
    };
  },
  created() {
    this.mostrarDatos();
    this.restore();
  },
  methods: {
    mostrarDatos: function () {
      axios.post(url, { opcion: 1 }).then((response) => {
        this.registros = response.data;
        console.log(response.data);
      });
    },
    tableToExcel(table, name) {
      if (!table.nodeType) table = this.$refs.table;
      var ctx = { worksheet: name || "Worksheet", table: table.innerHTML };
      window.location.href =
        this.uri + this.base64(this.format(this.template, ctx));
    },
    restore: function() {
      document.getElementById("Table").style.fontSize = "16px";
    },
    tableToPDF: function () {
      var doc = new jsPDF("l");
      document.getElementById("Table").style.fontSize = "9px";

      doc.html(this.$refs.table, {
        callback: function (doc) {
          doc.save("Reporte.pdf");
        },
        x: 10,
        y: 10,
      });
    },
  },
};
</script>