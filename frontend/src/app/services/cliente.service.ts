import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders, HttpResponse} from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import { map } from 'rxjs/operators';
import { GLOBAL } from './GLOBAL';

@Injectable()

export class ClienteService{

	//public url = "http://localhost:8000/floristeria1/backend/web";
	public url;
  public url2;
	constructor(
		private _http: HttpClient){
      this.url = GLOBAL.url;
      this.url2 = GLOBAL.url2;
    }

	create(cliente){
		let json = JSON.stringify(cliente);
		let params = "json="+json;

		let headers = new HttpHeaders().set('Content-Type','application/json');

		return this._http.post(this.url2+"/cliente/new", json,{headers: headers,observe: 'response'}).pipe(
      map((response: HttpResponse<any>) => {
        // Aquí puedes manejar la respuesta completa
        const status = response.status;
        const body = response.body;

        return { status, body };
      })
    );
	}

	listarClientes( page = null){
		if (page == null) {
			page = 1;
		}
		return this._http.get(this.url+"/cliente/listar?page="+page);
	}

	getCliente(id){
		return this._http.get(this.url2+"/cliente/"+id,{observe: 'response'}).pipe(
      map((response: HttpResponse<any>) => {
        // Aquí puedes manejar la respuesta completa
        const status = response.status;
        const body = response.body;

        return { status, body };
      })
    );
	}

	editCliente(cliente, id){
		let json = JSON.stringify(cliente);
		let params = "json="+json;
		let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded');

		return this._http.post(this.url+"/cliente/editar/"+id, params,{headers: headers});
	}

	listarClientespedido(){
		return this._http.get(this.url+"/pedido/clientes");
	}

	listarClienteSearch( page = null, search = null){
		if (page == null) {
			page = 1;
		}
		let http : any;
		if (search == null) {
			http = this._http.get(this.url+"/cliente/search/?page="+page);
		} else{
			http = this._http.get(this.url+"/cliente/search/"+search+"?page="+page);
		}
		return http;
	}

}
