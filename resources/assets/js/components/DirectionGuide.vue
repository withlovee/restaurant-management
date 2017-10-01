<template>
  <div class="direction-guide" v-show="route">
    <button v-on:click="close" class="close glyphicon glyphicon-remove"></button>
    <h3>Direction from
      <strong>{{fromAddress}}</strong> to
      <strong>{{toAddress}}</strong>
    </h3>
    <ol class="direction">
      <li class="step" v-for="step in steps">
        <span v-html="step.instructions"></span>
        ({{step.distance.text}})
      </li>
    </ol>
  </div>
</template>
 
<script>

  export default {
    props: [
      'routes',
    ],
    data() {
      return {
        route: null,
        steps: [],
        fromAddress: null,
        toAddress: null,
        destination: null,
      }
    },
    watch: {
      routes: function (newRoutes) {
        let route = newRoutes[0].legs[0];
        this.route = route;
        this.fromAddress = route.start_address;
        this.toAddress = route.end_address;
        this.steps = route.steps;
      }
    },
    methods: {
      close: function () {
        this.route = null;
        window.bus.$emit('remove-direction');
      }
    }
  }
</script> 
<style>
  h3 {
    margin-bottom: 20px;
  }
  .direction-guide {
    position: absolute;
    top: 50px;
    left: 0;
    bottom: 0;
    max-width: 300px;
    width: 100%;
    background-color: rgba(255,255,255,0.8);
    padding: 15px 20px;
    overflow-y: auto;
  }
  .direction {
    padding: 0 0 0 10px;
  }
  .step {
    border-top: 1px solid #ccc;
    padding: 15px 0 15px 10px;
    margin: 0 0 0 10px;
  }
</style>