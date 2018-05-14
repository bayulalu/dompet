@can('create', new App\Transaction)
@if (request('action') == 'add-income')
    <div id="transactionModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    {{ link_to_route('transactions.index', '&times;', [], ['class' => 'close']) }}
                    <h4 class="modal-title">{{ __('transaction.add_income') }}</h4>
                </div>
                {!! Form::open(['route' => 'transactions.store']) !!}
                {{ Form::hidden('in_out', 1) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">{!! FormField::text('date', ['required' => true, 'label' => __('app.date'), 'class' => 'date-select']) !!}</div>
                        <div class="col-md-6">{!! FormField::price('amount', ['required' => true, 'label' => __('transaction.amount')]) !!}</div>
                    </div>
                    {!! FormField::textarea('description', ['required' => true, 'label' => __('transaction.description')]) !!}
                </div>
                <div class="modal-footer">
                    {!! Form::submit(__('transaction.add_income'), ['class' => 'btn btn-success']) !!}
                    {{ link_to_route('transactions.index', __('app.cancel'), [], ['class' => 'btn btn-default']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endif
@if (request('action') == 'add-spending')
    <div id="transactionModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    {{ link_to_route('transactions.index', '&times;', [], ['class' => 'close']) }}
                    <h4 class="modal-title">{{ __('transaction.add_spending') }}</h4>
                </div>
                {!! Form::open(['route' => 'transactions.store']) !!}
                {{ Form::hidden('in_out', 0) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">{!! FormField::text('date', ['required' => true, 'label' => __('app.date'), 'class' => 'date-select']) !!}</div>
                        <div class="col-md-6">{!! FormField::price('amount', ['required' => true, 'label' => __('transaction.amount')]) !!}</div>
                    </div>
                    {!! FormField::textarea('description', ['required' => true, 'label' => __('transaction.description')]) !!}
                </div>
                <div class="modal-footer">
                    {!! Form::submit(__('transaction.add_spending'), ['class' => 'btn btn-success']) !!}
                    {{ link_to_route('transactions.index', __('app.cancel'), [], ['class' => 'btn btn-default']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endif
@endcan

@if (request('action') == 'edit' && $editableTransaction)
@can('update', $editableTransaction)
    <div id="transactionModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    {{ link_to_route('transactions.index', '&times;', ['date' => $date], ['class' => 'close']) }}
                    <h4 class="modal-title">{{ __('transaction.edit') }}</h4>
                </div>
                {!! Form::model($editableTransaction, ['route' => ['transactions.update', $editableTransaction],'method' => 'patch']) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">{!! FormField::text('date', ['required' => true, 'label' => __('app.date'), 'class' => 'date-select']) !!}</div>
                        <div class="col-md-6">{!! FormField::price('amount', ['required' => true, 'label' => __('transaction.amount')]) !!}</div>
                    </div>
                    {!! FormField::radios('in_out', [__('transaction.spending'), __('transaction.income')], ['required' => true, 'label' => __('transaction.transaction')]) !!}
                    {!! FormField::textarea('description', ['required' => true, 'label' => __('transaction.description')]) !!}
                </div>
                <div class="modal-footer">
                    {!! Form::submit(__('transaction.update'), ['class' => 'btn btn-success']) !!}
                    {{ link_to_route('transactions.index', __('app.cancel'), ['date' => $date], ['class' => 'btn btn-default']) }}
                    @can('delete', $editableTransaction)
                        {!! link_to_route(
                            'transactions.index',
                            __('app.delete'),
                            ['action' => 'delete', 'id' => $editableTransaction->id] + Request::only('page', 'date'),
                            ['id' => 'del-transaction-'.$editableTransaction->id, 'class' => 'btn btn-danger pull-left']
                        ) !!}
                    @endcan
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endcan
@endif

@if (request('action') == 'delete' && $editableTransaction)
@can('delete', $editableTransaction)
    <div id="transactionModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    {{ link_to_route('transactions.index', '&times;', ['date' => $editableTransaction->date], ['class' => 'close']) }}
                    <h4 class="modal-title">{{ __('app.delete') }} {{ $editableTransaction->type }}</h4>
                </div>
                <div class="modal-body">
                    <label class="control-label">{{ __('app.date') }}</label>
                    <p>{{ $editableTransaction->date }}</p>
                    <label class="control-label">{{ __('transaction.amount') }}</label>
                    <p>{{ $editableTransaction->amount }}</p>
                    <label class="control-label">{{ __('transaction.description') }}</label>
                    <p>{{ $editableTransaction->description }}</p>
                    {!! $errors->first('transaction_id', '<span class="form-error small">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="modal-body">{{ __('app.delete_confirm') }}</div>
                <div class="modal-footer">
                    {!! FormField::delete(
                        ['route' => ['transactions.destroy', $editableTransaction], 'class' => ''],
                        __('app.delete_confirm_button'),
                        ['class'=>'btn btn-danger'],
                        [
                            'transaction_id' => $editableTransaction->id,
                            'date' => request('date'),
                        ]
                    ) !!}
                    {{ link_to_route('transactions.index', __('app.cancel'), ['date' => $editableTransaction->date], ['class' => 'btn btn-default']) }}
                </div>
            </div>
        </div>
    </div>
@endcan
@endif
