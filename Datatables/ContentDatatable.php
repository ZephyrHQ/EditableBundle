<?php

namespace Zephyr\EditableBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class ContentDatatable.
 */
class ContentDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->topActions->set(array(
            'start_html' => '<div class="row"><div class="col-sm-3">',
            'end_html' => '<hr></div></div>',
            'actions' => array(
                array(
                    'route' => $this->router->generate('admin_content_new'),
                    'label' => $this->translator->trans('datatables.actions.new'),
                    'icon' => 'glyphicon glyphicon-plus',
                    'attributes' => array(
                        'rel' => 'tooltip',
                        'title' => $this->translator->trans('datatables.actions.new'),
                        'class' => 'btn btn-primary',
                        'role' => 'button',
                    ),
                ),
            ),
        ));

        $this->features->set(array(
            'auto_width' => true,
            'defer_render' => false,
            'info' => true,
            'jquery_ui' => true,
            'length_change' => true,
            'ordering' => true,
            'paging' => true,
            'processing' => true,
            'scroll_x' => false,
            'scroll_y' => '',
            'searching' => true,
            'server_side' => true,
            'state_save' => false,
            'delay' => 0,
            'extensions' => array(
                'buttons' => array(
                        'excel',
                        'pdf',
                        array(
                            'text' => 'Reload',
                            'action' => 'ZephyrEditableBundle::reload.js.twig',
                        ),
                    ),
                'responsive' => true,
            ),
        ));

        $this->ajax->set(array(
            'url' => $this->router->generate('admin_content_results'),
            'type' => 'GET',
        ));

        $this->options->set(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => 'lfrtip',
            'length_menu' => array(5, 10, 25, 50, 100),
            'order_classes' => true,
            'order' => array(array(0, 'asc')),
            'order_multi' => true,
            'page_length' => 5,
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
            'renderer' => '',
            'scroll_collapse' => false,
            'search_delay' => 0,
            'state_duration' => 7200,
            'stripe_classes' => array(),
            'class' => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering' => true,
            'individual_filtering_position' => 'both',
            'use_integration_options' => true,
            'force_dom' => true,
        ));

        $this->columnBuilder
            ->add('id', 'column', array(
                'title' => $this->translator->trans('dt.content.titles.id'),
            ))
            ->add('locale', 'column', array(
                'title' => $this->translator->trans('dt.content.titles.locale'),
                'editable' => true,
            ))
            ->add('page', 'column', array(
                'title' => $this->translator->trans('dt.content.titles.page'),
                'editable' => true,
            ))
            ->add('reference', 'column', array(
                'title' => $this->translator->trans('dt.content.titles.reference'),
                'editable' => true,
            ))
            ->add('content', 'column', array(
                'title' => $this->translator->trans('dt.content.titles.content'),
                'editable' => true,
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'admin_content_show',
                        'route_parameters' => array(
                            'id' => 'id',
                        ),
                        'label' => $this->translator->trans('datatables.actions.show'),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button',
                        ),
                    ),
                    array(
                        'route' => 'admin_content_edit',
                        'route_parameters' => array(
                            'id' => 'id',
                        ),
                        'label' => $this->translator->trans('datatables.actions.edit'),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.edit'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button',
                        ),
                    ),
                ),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'Zephyr\EditableBundle\Entity\Content';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'content_datatable';
    }
}
