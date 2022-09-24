<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gerenciador de Contatos</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <!-- Styles -->
        <style>
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="">

        <div class="container-fluid">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Contatos</h3>
                </div>
                <form class="form" id="form_contato" enctype="multipart/form-data" method="post" action="javascript:;">
                    <input type="hidden" name="_token" value="{!! csrf_token()!!}">
                    <input type="hidden" id="contato_id" name="contato_id" value="{{$oContato->contato_id}}">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label class="" for="nome_contato">Nome *</label>
                                    <input class="form-control" required type="text" id="nome_contato" name="nome_contato" value="{{$oContato->nome}}">
                                </div>
                                <div class="col-lg-2">
                                    <label class="" for="cpf_contato">CPF *</label>
                                    <input class="form-control" required type="text" id="cpf_contato" name="cpf_contato" value="{{$oContato->cpf}}">
                                </div>
                                <div class="col-lg-2">
                                    <label class="" for="email_contato">E-mail</label>
                                    <input class="form-control" type="text" id="email_contato" name="email_contato" value="{{$oContato->email}}">
                                </div>
                                <div class="col-lg-2">
                                    <label class="" for="telefone_contato">Telefone</label>
                                    <input class="form-control" type="text" id="telefone_contato" name="telefone_contato" value="{{$oContato->telefone}}">
                                </div>
                            </div>
                                <div class="col-lg-2">
                                    <label class="" for="principal_contato">Principal</label>
                                    <input class="" type="checkbox" id="principal_contato" name="principal_contato" value="{{$oContato->principal}}">
                                </div>
                        </div>
                        <div class="card-footer">
                            <center>
                                <button type="submit" class="btn btn-primary" id="submit_form_funcionario" name="submit_form_funcionario">Adcionar</button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid">

            <div class="card card-custom">
                <table id="table_contatos" nome="table_contatos" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Principal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aDadosContatos as $key => $contato)
                            <tr>
                                <td>{{$contato->nome}}</td>
                                <td>{{$contato->cpf}}</td>
                                <td>{{$contato->email}}</td>
                                <td>{{$contato->telefone}}</td>
                                <td>{{$contato->principal ? "Sim" : "Não"}} {{$contato->principal}}</td>
                                <td>
                                    <button onclick="buttonAction('{{route($routeEditContato, $contato->contato_id);}}', 'GET', 'edit')" type="text" class="btn btn-primary" name="submit_form_funcionario">Editar</button>
                                    <button onclick="confirm('Deseja excluir este contato?') ? buttonAction('{{route($routeDeleteContato, $contato->contato_id)}}', 'POST', 'delete') : ''" type="text" class="btn btn-danger" name="submit_form_funcionario">Excluir</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            $("#principal_contato").on('change', function(event) {
                if(this.checked){
                    $('#principal_contato').attr('checked', 'checked');
                    $('#principal_contato').attr('value', '1');
                }else{
                    $('#principal_contato').attr('value', '');
                    $('#principal_contato').removeAttr('checked');
                }
            });
            function atualizarTabela(json){
                $('#contato_id').val('');
                $('#nome_contato').val('');
                $('#cpf_contato').val('');
                $('#email_contato').val('');
                $('#telefone_contato').val('');
                $('#principal_contato').val('');
                $('#submit_form_funcionario').text('Adicionar');

                $("#table_contatos").empty();
                var newHead = $("<thead>");
                newHead.appendTo('#table_contatos');   
                var newRow = $("<tr>");
                $("<th>Nome</th>").appendTo(newRow);
                $("<th>CPF</th>").appendTo(newRow);
                $("<th>E-mail</th>").appendTo(newRow);
                $("<th>Telefone</th>").appendTo(newRow);
                $("<th>Principal</th>").appendTo(newRow);
                $("<th>Ações</th>").appendTo(newRow);
                newRow.appendTo('#table_contatos>thead');   
                
                
                var newBody = $("<tbody>");
                newBody.appendTo('#table_contatos');
                Object.values(json).map(contato => {
                    if(contato.contato_id !== undefined){
                        newRow = $("<tr>");
                        $("<td>"+contato.nome+"</td>").appendTo(newRow);
                        $("<td>"+contato.cpf+"</td>").appendTo(newRow);
                        $("<td>"+contato.email+"</td>").appendTo(newRow);
                        $("<td>"+contato.telefone+"</td>").appendTo(newRow);
                        $("<td>"+(contato.principal==1 ? "Sim" : "Não") +"</td>").appendTo(newRow);
                        fButtonEdit = "buttonAction('"+contato.routeEdit+"', 'GET', 'edit')";
                        fButtonDelete = "confirm('Deseja excluir este contato?') ? buttonAction('"+contato.routeDelete+"', 'POST', 'delete') : ''"; 
                        buttonEdit = "<button onclick=\""+fButtonEdit+"\" type=\"text\" class=\"btn btn-primary\" name=\"submit_form_funcionario\">Editar</button>";
                        buttonDelete = " <button onclick=\""+fButtonDelete+"\" type=\"text\" class=\"btn btn-danger\" name=\"submit_form_funcionario\">Excluir</button>";
                        $("<td>"+ buttonEdit + buttonDelete +"</td>").appendTo(newRow);
                        newRow.appendTo('#table_contatos>tbody');   
                    }
                })
            }
            $("#form_contato").on('submit', function(event) {
                event.preventDefault(); 
                data = $("#form_contato").serialize();
                $.ajax({
                    url: '{{route($routeForm)}}',
                    dataType: "JSON", 
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name=\'csrf-token\']").attr("content")
                    },
                    data: data,
                    success: function(json, data){
                        if(json.status == 'success') {
                            atualizarTabela(json);
                        }else{
                            alert(json.msg);
                        }
                    },
                    error : function (XMLHttpRequest, textStatus, errorThrown) {
                    }
                });
            });

            function deleteContato(json){
                alert(json.msg);
                atualizarTabela(json);
            }

            function editContato(json){
                $('#contato_id').val(json.contato_id);
                $('#nome_contato').val(json.nome);
                $('#cpf_contato').val(json.cpf);
                $('#email_contato').val(json.email);
                $('#telefone_contato').val(json.telefone);
                $('#principal_contato').val(json.principal);
                if(json.principal == 1){
                    $('#principal_contato').attr('checked', 'checked');
                }else{
                    $('#principal_contato').removeAttr('checked');
                }
                $('#submit_form_funcionario').text('Gravar');
            }
            function buttonAction(route, method, action){
                $.ajax({
                    url: route,
                    dataType: "JSON", 
                    type: method,
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name=\'csrf-token\']").attr("content")
                    },
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(json){
                        switch (action) {
                            case 'edit':
                                editContato(json);
                                break;
                            case 'delete':
                                deleteContato(json);
                                break;
                            break;
                        }
                    },
                    error : function (XMLHttpRequest, textStatus, errorThrown) {
                    }
                });
            };

            $(document).ready(function () { 
                var $seuCampoCpf = $("#cpf_contato");
                $seuCampoCpf.mask('000.000.000-00', {reverse: true});
                var $seuCampoCpf = $("#telefone_contato");
                $seuCampoCpf.mask('(00) 0000-0000', {reverse: true});
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </body>
</html>
