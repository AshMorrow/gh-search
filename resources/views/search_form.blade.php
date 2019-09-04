@extends('adminlte::page')

@section('content')
    <div class="col-lg-6 gh-search">
        <div class="box">
            <div id="gh_search_rule" class="box-body">
            </div>
            <div class="box-footer">
                <div class="pull-left">
                    <button id="gh_submit" class="btn btn-info">Apply</button>
                    <button id="gh_clear" class="btn btn-warning">Clear</button>
                </div>
                <div class="pull-right">
                    <button id="gh_add_rule" class="btn btn-success">Add rule</button>
                </div>
            </div>
        </div>
        <div id="rule_pattern" class="hidden">
            <div class="rule-group form-group">
                <select name="gh_field" class="field form-control">
                    <option>size</option>
                    <option>forks</option>
                    <option>stars</option>
                    <option>followers</option>
                </select>
                <select name="gh_operator" class="operator form-control">
                    <option><</option>
                    <option>></option>
                    <option>=</option>
                </select>
                <input name="gh_value" type="text" class="value form-control" value="0">
                <div>
                    <button class="gh-delete-rule btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="box">
            <div class="gh-response box-body">
            </div>
        </div>
@endsection
@push('css')
    <style>
        .rule-group {
            display: flex;
        }
        .rule-group .form-control {
            margin-right: 5px;
        }
    </style>
@endpush
@push('js')
    <script>
        addRule = function() {
            $('#rule_pattern .rule-group').clone(true).appendTo('#gh_search_rule')
        };

        $(function () {
            $('#gh_add_rule').click(function () {
                addRule();
            });
            $('#gh_clear').click(function () {
                $('#gh_search_rule').html('');
            });

            $('.gh-delete-rule').click(function () {
               $(this).closest('.rule-group').remove();
            });

            $('#gh_submit').click(function () {
                let $rules = $('#gh_search_rule .rule-group');
                let preparedRules = [];
                let url = "{{route('search.GHSearch')}}";

                $rules.each(function (i, group) {
                    preparedRules.push({
                        "field": $(group).find('.field').val(),
                        "operator": $(group).find('.operator').val(),
                        "value": $(group).find('.value').val(),
                    });
                });

                console.log(preparedRules);

                $.ajax({
                    url: url,
                    data: {"rules" : preparedRules},
                    method: 'GET'
                }).done(function(response) {
                   $('.gh-response').html(response);
                });
            })
        })
    </script>
@endpush