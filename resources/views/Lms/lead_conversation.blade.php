<div class="row">
    <div class="col-md-12">
        <!-- DIRECT CHAT SUCCESS -->
        <div class="card card-sucress cardutline direct-chat direct-chat-success collapsed-card rounded-0">
            <div class="card-header">
                <h3 class="card-title">Lead Conversation</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg">
                        {{--<div class="direct-chat-infos clearfix">--}}
                            {{--<span class="direct-chat-name float-left">{{ $result[0]->created_by }}</span>--}}
                            {{--<span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>--}}
                        {{--</div>--}}
                        <!-- /.direct-chat-infos -->
                        {{--<img class="direct-chat-img" src="{{ URL::asset('public/dist/img/user1-128x128.jpg') }}" alt="Message User Image">--}}
                        <!-- /.direct-chat-img -->
                        <div class="lead-chat">
                        <div class="direct-chat-text">
                            <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                            Is this template really for free? That's unbelievable!
                        </div>
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                </div>
                <!--/.direct-chat-messages-->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <form id="lead-conv-form">
                    <input type="hidden" name="leadId" value="{{ $result[0]->id }}">
                    <div class="input-group">
                        <div class="col-md-9">
                            <input type="text" name="comment" placeholder="Type Message ..." class="form-control form-control-sm">
                        </div>
                             <input type="text" name="reminder" placeholder="Reminder" class="form-control form-control-sm date">
                        <span class="input-group-append">
                          <button type="button" onclick="lead_conversation(this)" class="btn btn-success btn-sm">Send</button>
                        </span>
                    </div>
                </form>
            </div>
            <!-- /.card-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->