<?php

use app\helpers\App;
use yii\helpers\Html;

?>


 <!--begin::Example-->
<div class="example mb-10">
    <p>Add the base class
    <code>.table</code>to any
    <code>table</code>, then extend with custom styles or our various included modifier classes.</p>
    <div class="example-preview">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Nick</td>
                    <td>Stone</td>
                    <td>
                        <span class="label label-inline label-light-primary font-weight-bold">Pending</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Ana</td>
                    <td>Jacobs</td>
                    <td>
                        <span class="label label-inline label-light-success font-weight-bold">Approved</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>Pettis</td>
                    <td>
                        <span class="label label-inline label-light-danger font-weight-bold">New</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="example-code">
        <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
        <div class="example-highlight">
            <pre style="height:200px">
                <code class="language-html">
                                    &lt;table class="table"&gt;
                                        &lt;thead&gt;
                                            &lt;tr&gt;
                                                &lt;th scope="col"&gt;#&lt;/th&gt;
                                                &lt;th scope="col"&gt;First&lt;/th&gt;
                                                &lt;th scope="col"&gt;Last&lt;/th&gt;
                                                &lt;th scope="col"&gt;Status&lt;/th&gt;
                                            &lt;/tr&gt;
                                        &lt;/thead&gt;
                                        &lt;tbody&gt;
                                            &lt;tr&gt;
                                                &lt;th scope="row"&gt;1&lt;/th&gt;
                                                &lt;td&gt;Nick&lt;/td&gt;
                                                &lt;td&gt;Stone&lt;/td&gt;
                                                &lt;td&gt;
                                                    &lt;span class="label label-inline label-light-primary font-weight-bold"&gt;
                                                        Pending
                                                    &lt;/span&gt;
                                                &lt;/td&gt;
                                            &lt;/tr&gt;
                                            &lt;tr&gt;
                                                &lt;th scope="row"&gt;2&lt;/th&gt;
                                                &lt;td&gt;Ana&lt;/td&gt;
                                                &lt;td&gt;Jacobs&lt;/td&gt;
                                                &lt;td&gt;
                                                    &lt;span class="label label-inline label-light-success font-weight-bold"&gt;
                                                        Approved
                                                    &lt;/span&gt;
                                                &lt;/td&gt;
                                            &lt;/tr&gt;
                                            &lt;tr&gt;
                                                &lt;th scope="row"&gt;3&lt;/th&gt;
                                                &lt;td&gt;Larry&lt;/td&gt;
                                                &lt;td&gt;Pettis&lt;/td&gt;
                                                &lt;td&gt;
                                                    &lt;span class="label label-inline label-light-danger font-weight-bold"&gt;
                                                        New
                                                    &lt;/span&gt;
                                                &lt;/td&gt;
                                            &lt;/tr&gt;
                                        &lt;/tbody&gt;
                                    &lt;/table&gt;</code>
            </pre>
        </div>
    </div>
</div>
<!--end::Example-->
<!--begin::Example-->
<div class="example mb-10">
    <p>Invert the colors with light text on dark backgrounds using
    <code>.table-dark</code>.</p>
    <div class="example-preview">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Nick</td>
                    <td>Stone</td>
                    <td>
                        <span class="label label-inline label-light-primary font-weight-bold">Pending</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Ana</td>
                    <td>Jacobs</td>
                    <td>
                        <span class="label label-inline label-light-success font-weight-bold">Approved</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>Pettis</td>
                    <td>
                        <span class="label label-inline label-light-danger font-weight-bold">New</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="example-code">
        <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
        <div class="example-highlight">
            <pre>
                <code class="language-html">
                                        &lt;table class="table table-dark"&gt;
                                            ...
                                        &lt;/table&gt;</code>
                </pre>
        </div>
    </div>
</div>
<!--end::Example-->
<!--begin::Example-->
<div class="example">
    <p>Add
    <code>.rounded</code>class to
    <code>.table</code>for rounded edges.</p>
    <div class="example-preview">
        <table class="table table-dark rounded">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Nick</td>
                    <td>Stone</td>
                    <td>
                        <span class="label label-inline label-light-primary font-weight-bold">Pending</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Ana</td>
                    <td>Jacobs</td>
                    <td>
                        <span class="label label-inline label-light-success font-weight-bold">Approved</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>Pettis</td>
                    <td>
                        <span class="label label-inline label-light-danger font-weight-bold">New</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="example-code">
        <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
        <div class="example-highlight">
            <pre>
                <code class="language-html">
                                        &lt;table class="table table-dark rounded"&gt;
                                            ...
                                        &lt;/table&gt;</code>
                </pre>
        </div>
    </div>
</div>
<!--end::Example-->


            