@extends('html.default')


@section('content')
 <div class="body-content__header">
                <ul>
                    <li><a href="#">Requisition Summary</a></li>
                </ul>
                <button class="btn-requisition-list"><i class="icon-20"></i> Requisition List</button>
            </div>
            <div class="body-content__wrapper requesition-body">
                <div class="requesition-top">
                    <ul class="requesition-btn-list">
                        <li><button><img src="assets/img/copy-icon.png" alt=""> Copy</button></li>
                        <li><button><img src="assets/img/csv-icon.png" alt=""> CSV</button></li>
                        <li><button><img src="assets/img/excel-icon.png" alt=""> Excel</button></li>
                        <li><button><img src="assets/img/pdf-icon.png" alt=""> PDF</button></li>
                        <li><button><img src="assets/img/print-icon.png" alt=""> Print</button></li>
                    </ul>
                    <div class="requesition-search">
                        <input type="search" placeholder="Search Here.........">
                        <button><img src="assets/img/search-icon.png" alt=""></button>
                    </div>
                </div>
                <div class="requesition-table">
                    <table id="example" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vendor</th>
                                <th>Services</th>
                                <th>Payment Method</th>
                                <th>Department</th>
                                <th>Expenses</th>
                                <th>Project Code</th>
                                <th>(ZAR) amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <div class="requesition-bottom">
                    <div class="page-number">
                        <label for="">Records per page:</label>
                        <select name="">
                            <option value="">21</option>
                            <option value="">21</option>
                            <option value="">21</option>
                        </select>
                    </div>
                    <ul class="requesition-pagination">
                        <li><button><img src="assets/img/pagi-arrow-left.png" alt=""></button></li>
                        <li>
                            <p>0 to 100</p>
                        </li>
                        <li><button><img src="assets/img/pagi-arrow-next.png" alt=""></button></li>
                    </ul>
                </div>
            </div>
@endsection
