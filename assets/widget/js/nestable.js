class NestableWidget {
    index = 0;

    constructor({widgetId, defaultName}) {
        this.defaultName = defaultName;
        this.widgetId = widgetId;
    }

    initNestable() {
        let self = this,
            nestableMenu = $(`#nestable-menu-${self.widgetId}`),
            dd = $(`#dd-${self.widgetId}`);

        if (nestableMenu.length) {
            nestableMenu.on('click', function(e) {
                let target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    dd.nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    dd.nestable('collapseAll');
                }
            });
            dd.nestable({maxDepth: 4, default_name: self.defaultName});
            dd.nestable('createName');
        }
    }

    generateListItem() {
        const { index, widgetId } = this;
        return `
            <li class="dd-item dd3-item" data-id="${index}-new">
                <div class="dd-handle dd3-handle"> <i class="flaticon-squares"></i></div>
                <div class="dd3-content">
                    <div class="row">
                        <div class="col-md-3">
                            <input data-id="label" type="text" class="form-control"  placeholder="Label" required>
                        </div>
                        <div class="col-md-3">
                            <input list="link-list-${widgetId}" data-id="link" type="text" class="form-control"  placeholder="Link" required>
                        </div>
                        <div class="col-md-3">
                            <textarea  data-id="icon" type="text" class="form-control"  placeholder="Icon" rows="1" required></textarea>
                        </div>
                        <div class="col-md-2">
                           <div class="checkbox-list">
                               <label class="checkbox">
                                    <input class="checkbox" data-id="new_tab" type="checkbox"value="1">
                                        <span></span>New Tab
                                </label>
                                <label class="checkbox">
                                    <input class="checkbox" data-id="group_menu" type="checkbox"value="1">
                                        <span></span>Group Menu
                                </label>
                            </div>
                        </div>
                        <span  style="position: absolute; right: 5px;">
                            <a href="#!" class="btn btn-danger btn-sm btn-icon mr-2 btn-remove-menu">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a href="#!" class="btn btn-outline-secondary btn-sm btn-icon mr-2 btn-add-more-menu" title="Insert Below">
                                <i class="fa fa-plus"></i>
                            </a>
                        </span>
                    </div>
                </div>
            </li>
        `;
    }


    init() {
        let self = this,
            dd = $(`#dd-${self.widgetId}`);

        dd.on('change', function() {
            $(this).nestable('createName');
        });

        $(document).on('click', `#${self.widgetId} .btn-add-more-menu`, function(e) {
            e.preventDefault();
            self.index++;
            $(this).closest('li.dd-item').after(self.generateListItem());
            dd.trigger('change');
        });

        $(document).on('click', `#${self.widgetId} .btn-remove-menu`, function(e) {
            e.preventDefault();
            var confirm_dialog = confirm('Are you sure?');
            if (confirm_dialog) {
                $(this).closest('li').remove();
            }
        });

        $(`#add-main-navigation-${self.widgetId}`).on('click', function(e) {
            e.preventDefault();
            self.index++;
            $(`#ol-dd-list-${self.widgetId}`).prepend(self.generateListItem());
            dd.trigger('change');
        });

        self.initNestable();
    }
}