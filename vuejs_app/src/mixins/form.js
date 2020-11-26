export const formMixin = {
  data : () => ({
    rules: {
			required: value => !!value || 'Requis',
      maxLength: (value = '', max = 255) => value.length <= max || `Le champ ne peut pas dépasser ${max} caractères`,
      email: value => {
				const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
				return regex.test(value) || 'Le mail n\'est pas valide'
      },
      password: value => {
        const regex = /^(?=.*\d)(?=.*[a-zA-Z])[0-9a-zA-Z]{8,}$/
        return regex.test(value) || 'Le mot de passe doit contenir 8 charactères minimum dont au moins un nombre et une lettre'
      }
		},
  })
}