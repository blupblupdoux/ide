<template>

  <v-text-field 
    :type="type"
    :label="label"  
    :value="!addUser ? value : null"
    @input="updateValue()" 
    :rules="rules"
    :readonly="!modifUser && !addUser" 
    dense
    outlined>
  </v-text-field>
  
</template>

<script>
export default {
  name: 'UserFormTextField',
  props: ['addUser', 'modifUser', 'label', 'value', 'type', 'rules'],
  methods: {
    updateValue() {
      this.$emit('input', event.target.value)
    }
  }
}
</script>

<style>

</style>