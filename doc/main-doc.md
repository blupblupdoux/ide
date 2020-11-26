# Main Documentation

## Form verifications rules

For front-end verifications of the form field we use vuetify verification system.  
All of the globales verification rules are in src/mixins/form.js (in data : rules) but we can had specifics rules in the component we want by adding to the data a localRules array (working the same as rules).