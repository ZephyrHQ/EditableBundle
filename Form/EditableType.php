<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Zephyr\EditableBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zephyr\EditableBundle\Entity\Content;
use Zephyr\EditableBundle\Repository\ContentRepository;

/**
 * Description of EditableType.
 *
 * @author Nicolas de Marqué <nicolas.demarque@gmail.com>
 */
class EditableType extends AbstractType
{
    /** @var EntityManager */
    private $entityManager;

    /** @var ContentRepository */
    private $repository;

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('ZephyrEditableBundle:Content');
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->setPreSetData($builder)
            ->setPostSubmit($builder)
        ;
    }

    /**
     * @param FormBuilderInterface $builder
     *
     * @return EditableType
     */
    protected function setPreSetData(FormBuilderInterface $builder)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $content = $this->findContent($form);
            $form->setData(false !== $content ? $content->getContent() : '');
        });

        return $this;
    }

    /**
     * @param FormBuilderInterface $builder
     *
     * @return EditableType
     */
    protected function setPostSubmit(FormBuilderInterface $builder)
    {
        $builder->addEventListener(
            FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $content = $this->findContent($form);
            $content->setContent($form->getData());
            $this->entityManager->persists($content);
            $this->entityManager->flush();
        });

        return $this;
    }

    /**
     * @param FormInterface $form
     *
     * @return Content
     */
    protected function findContent(FormInterface $form)
    {
        return $this->repository->findOneBy([
                'locale' => $form->getConfig()->getOption('locale'),
                'page' => $form->getConfig()->getOption('page'),
                'reference' => $form->getConfig()->getOption('reference'),
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'locale' => 'fr',
            'page' => null,
            'reference' => null,
        ));

        $resolver->setAllowedValues('locale', ['single_text', 'text']);
        $resolver->setAllowedValues('page', ['single_text', 'text']);
        $resolver->setAllowedValues('reference', ['single_text', 'text']);
    }

    public function getParent()
    {
        return TextType::class;
    }
}
