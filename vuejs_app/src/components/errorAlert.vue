<template>
  <v-row>
    <v-alert class="ml-auto mr-10" type="error" dense>{{ message }}</v-alert>
</v-row>
</template>

<script>
export default {
	name: 'ErrorAlert',
	props: ['message']
}
</script>
