function contador (campo, cuentacampo, limite) {
	if (campo.value.length > limite) campo.value = campo.value.substring(0, limite);
	else cuentacampo.value = limite - campo.value.length;}