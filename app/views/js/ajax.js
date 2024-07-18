const form_ajax=document.querySelectorAll(".AjaxForm");
const confirmForm=document.querySelectorAll(".ConfirmForm");
const loadingForm=document.querySelectorAll(".Loading");
const divAlert=document.getElementById("divAlert");

form_ajax.forEach(forms => {
	forms.addEventListener("submit",function(e) {
		e.preventDefault();
		divAlert.innerHTML="";
		let data = new FormData(this);
		let method = this.getAttribute("method");
		let action = this.getAttribute("action");
		let headers = new Headers();
		let config = {
			method:method,
			headers:headers,
			mode:'cors',
			cache:'no-cache',
			body:data
		};
		fetch(action,config)
		.then(response=>response.json())
		.then(response => {
			return ajax_alert(response);
		});
	});
});

loadingForm.forEach(forms => {
	forms.addEventListener("submit",function(e) {
		e.preventDefault();
		document.getElementById('loading').style.display = 'block';
		divAlert.innerHTML="";
		let data = new FormData(this);
		let method = this.getAttribute("method");
		let action = this.getAttribute("action");
		let headers = new Headers();
		let config = {
			method:method,
			headers:headers,
			mode:'cors',
			cache:'no-cache',
			body:data
		};
		fetch(action,config)
		.then(response=>response.json())
		.then(response => {
			document.getElementById('loading').style.display = 'none';
			return ajax_alert(response);
		})
		.catch(error => {
            document.getElementById('loading').style.display = 'none'; // Asegura que el loading se oculte incluso si hay un error
            // console.error('Error:', error);
        });
	});
});

confirmForm.forEach(forms => {
	forms.addEventListener("submit",function(e) {
		e.preventDefault();
		divAlert.innerHTML="";
		Swal.fire({
		  title: "¿Está seguro?",
		  text: "¿Desea realmente realizar esta acción?",
		  icon: "question",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Si, seguro!",
		  cancelButtonText: "No, Cancelar"
		}).then((result) => {
		  	if (result.isConfirmed) {
				let data = new FormData(this);
				let method = this.getAttribute("method");
				let action = this.getAttribute("action");
				let headers = new Headers();
				let config = {
					method:method,
					headers:headers,
					mode:'cors',
					cache:'no-cache',
					body:data
				};
				fetch(action,config)
				.then(response=>response.json())
				.then(response => {
					return ajax_alert(response);
				});
		  	}
		});
	});
});


function ajax_alert(alert) {
	if (alert.type=="pop-up") {
		Swal.fire({
			position: alert.position,
			icon: alert.icon,
			title: alert.title,
			text: alert.text,
			showConfirmButton: false,
			confirmButtonColor: "#3085d6",
			timer: alert.timer*1000
		});
		////////////////
		//POSITION    //
		//center      //
		//top         //
		//bottom   	  //
		//xxxxx-end	  //
		//xxx-start	  //
		////////////////
		
		/////////////
		//ICONS    //
		//success  //
		//error    //
		//warning  //
		//info     //
		//question //
		/////////////
	}else if (alert.type=="msg") {
		divAlert.innerHTML='<div class="alert alert-'+alert.icon+'" role="alert"><b>'+alert.title+':</b> '+alert.text+'</div>';
		if (alert.focus) {
			document.getElementById(alert.focus).focus();
		}


		////////////////
		//TYPE ALERTS //
		//primary     //
		//secondary   //
		//success     //
		//danger      //
		//warning     //
		//info        //
		//light       //
		//dark        //
		////////////////
	}else if (alert.type=="reload") {
		Swal.fire({
			title: alert.title,
			text: alert.text,
			icon: alert.icon,
			confirmButtonColor: "#3085d6",
			confirmButtonText: "Aceptar"
		}).then((result) => {
			location.reload();
		});
	}else if (alert.type=="clean") {
		Swal.fire({
			position: alert.position,
			title: alert.title,
			text: alert.text,
			icon: alert.icon,
			showConfirmButton: false,
			timer: alert.timer*1000
		}).then((result) => {
			if (form_ajax.length!=0) {
				document.querySelector(".AjaxForm").reset();
			}
			if (confirmForm.length!=0) {
				document.querySelector(".ConfirmForm").reset();
			}
			if (loadingForm!=0) {
				document.querySelector(".Loading").reset();
			}
		});
	}else if (alert.type=="redirect") {
		window.location.href=alert.url;
	}else if (alert.type=="newPage") {
		var win = window.open(alert.url, '_blank');
        win.focus();
	}else if (alert.type=="ajax") {
		 $.ajax({
            type: "POST",
            url: alert.url,
            data: alert.data,
            success:function (r) {
                divAlert.innerHTML=r;
            }
        })
	}else if (alert.type=="clipboard") {
		navigator.clipboard.writeText(alert.url)
		.then(() => {
			Swal.fire({
				title: alert.title,
				text: alert.text,
				icon: alert.icon,
				confirmButtonColor: "#3085d6",
				confirmButtonText: "Aceptar"
			}).then((result) => {
				// window.open(alert.url, '_blank');
				if (alert.redirect) {
					location.href=alert.redirect;
				}
			});
		},() => {
			Swal.fire({
				title: "No se ha podido copiar al portapapeles",
				text: "ERROR",
				icon: "error",
				confirmButtonColor: "#3085d6",
				confirmButtonText: "Aceptar"
			}).then((result) => {
			});
		});
	}
}


