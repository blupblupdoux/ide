<template>
  <v-list-item link> 
    <v-list-item-icon>
      <v-icon color="primary">{{ icon }}</v-icon>
    </v-list-item-icon>
    <v-list-item-content class="py-0">
      <v-list-item-title>{{ name }}</v-list-item-title>
    </v-list-item-content>
  </v-list-item>
</template>

<script>
export default {
  name: 'NavbarItem',
  props: ['name', 'icon']
}
</script>

<style>

</style>