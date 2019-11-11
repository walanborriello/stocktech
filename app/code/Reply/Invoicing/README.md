#Reply Invoicing

Il modulo implementa le customizzazioni necessarie per la gestione della fatturazione.

- flag "want_invoice" che deve selezionare l'utente per richiedere fattura. Dato che viene poi comunicato a JStore, per la generazione o meno della fattura
- differenziazione tra Partita Iva (campo vat_number) e Codice Fiscale (che è un campo nuovo a db)
- chiamate al servizio per la verifica della validità della Partita IVA (servizio di Gottardo che si basa su base dati fornita dai servizi di Cerved)
- validazione del Codice Fiscale