$(function(){
	$("#form" ).validate({
	  rules: {
	    nama_barang: {
	    	required : true,
	    	maxlength : 30
	    },
	    barcode:"required",
	    jenis_barang: "required",
	    harga_beli: {
	    	required: true,
	    	number: true
	    },
	    harga_jual: {
	    	required: true,
	    	number: true
	    },
	    stok: {
	    	required: true,
	    	number: true
	    }
	  },
	  messages:{
	  	nama_barang: {
	  		required : "Nama barang tidak boleh kosong.",
	  		maxlength: "Nama Barang tidak lebih dari 30 Karakter"
	  	},
	  	barcode: "Barcode tidak boleh kosong",
	  	jenis_barang: "Jenis barang tidak boleh kosong.",
	  	harga_jual:{
	  		required: "Harga jual tidak boleh kosong.",
	  		number: "Harga jual hanya dapat diisi dengan angka.",

	  	},
	  	harga_beli:{
	  		required: "Harga beli tidak boleh kosong.",
	  		number: "Harga beli hanya dapat diisi dengan angka."
	  	},
	  	stok:{
	  		required: "Stok tidak boleh kosong.",
	  		number: "Stok hanya dapat diisi dengan angka."
	  	},
	  },
	  submitHandler: function(form) {
	    save();
	  }
	});
})