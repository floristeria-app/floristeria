import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { GLOBAL } from './GLOBAL';

@Injectable()

export class ImagenTarjetaService{

	//public url = "http://localhost:8000/floristeria1/backend/web";
	public url;

	constructor(
		private _http: HttpClient){
      this.url = GLOBAL.url;
    }


	makefilerequest( imagentarjeta, files: Array<File> ){
		return new Promise((resolve, reject) =>{
			let json = JSON.stringify(imagentarjeta);
			let formData:any = new FormData();
			let xhr = new XMLHttpRequest();
			for (var i = 0 ; i < files.length; i++) {
				formData.append("image",files[i],files[i].name);
			}
			formData.append("json",json);

			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {
						resolve(JSON.parse(xhr.response));
					}else{
						reject(xhr.response);
					}
				}
			}
			xhr.open("POST",this.url+"/imagen-tarjeta/new", true);
			xhr.send(formData);



		});
	}

	listarImagenes(){
		return this._http.get(this.url+"/imagen-tarjeta/listar");
	}

	getImgenTarjeta(id){
		return this._http.get(this.url+"/imagen-tarjeta/"+id);
	}

	updatefilerequest( imagentarjeta, files: Array<File>, id ){
		return new Promise((resolve, reject) =>{
			let json = JSON.stringify(imagentarjeta);
			var formData:any = new FormData();
			var xhr = new XMLHttpRequest();
			for (var i = 0 ; i < files.length; i++) {
				formData.append("image",files[i],files[i].name);
			}
			formData.append("json",json);

			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {
						resolve(JSON.parse(xhr.response));
					}else{
						reject(xhr.response);
					}
				}
			}
			xhr.open("POST",this.url+"/imagen-tarjeta/editar/"+id, true);
			xhr.send(formData);
		});
	}

	remove(id){
		return this._http.get(this.url+"/imagen-tarjeta/remove/"+id);
	}

	listarImagenesPorMotivo(id){
		return this._http.get(this.url+"/imagen-tarjeta/por-motivo/"+id);
	}
}
