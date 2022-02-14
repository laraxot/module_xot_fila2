<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

//use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Modules\Xot\Models\Panels\Actions\XotBasePanelAction;

/**
 * Undocumented interface.
 *
 * @property Model $row
 */
interface PanelContract {
    public function setRow(Model $row): self;

    //public function setRows(Relation $rows): self;

    /**
     * Undocumented function.
     *
     * @param Relation|Builder $rows
     */
    public function setRows($rows): self;

    /**
     * Undocumented function.
     *
     * @return Relation|Builder
     */
    public function getRows();

    public function setItem(string $guid): self;

    public function setParent(?PanelContract $panel): PanelContract;

    /**
     * Undocumented function.
     *
     * @return RowsContract
     */
    public function rows(?array $data = null);

    /**
     * @return mixed
     */
    public function update(array $data);

    /**
     * Ritorna la view.
     *
     * @return View
     */
    public function view(?array $params = null);

    /**
     * Undocumented function.
     *
     * @return mixed
     */
    public function itemAction(string $act);

    public function relatedUrl(string $name, string $act = 'index'): string;

    public function setLabel(string $label): Model;

    public function postType(): string;

    public function imgSrc(array $params): string;

    public function getRow(): Model;

    /**
     * Undocumented function.
     *
     * @return \Illuminate\Http\File|\Illuminate\Http\UploadedFile|\Psr\Http\Message\StreamInterface|resource|string
     */
    public function pdf(array $params = []);

    public function pdfFilename(array $params = []): string;

    public function setInAdmin(bool $in_admin): self;

    public function setRouteParams(array $route_params): void;

    public function getXotModelName(): ?string;

    public function url(string $act = 'show'): string;

    public function itemActions(array $params = []): Collection;

    public function id(?bool $is_admin = null): string;

    public function title(): ?string;

    public function with(): array;

    public function setName(string $name): self;

    public function tabs(): array;

    /**
     * @return Collection&iterable<PanelContract>
     */
    public function getBreads();

    public function getRouteParams(): array;

    public function guid(?bool $is_admin = null): ?string;

    public function getParent(): ?PanelContract;

    public function fields(): array;

    public function actions(): array;

    public function getModuleNameLow(): string;

    public function getModuleName(): string;

    public function getName(): string;

    /**
     * @return mixed
     */
    public function getOrderField();

    /**
     * Undocumented function.
     *
     * @return mixed
     */
    public function callAction(string $act);

    /**
     * Undocumented function.
     *
     * @return mixed
     */
    public function out(array $params = []);

    /**
     * Undocumented function.
     *
     * @return mixed
     */
    public function callItemActionWithGate(string $act);

    /**
     * Undocumented function.
     *
     * @return Collection<PanelContract>
     */
    public function getParents();

    /**
     * @return mixed
     */
    public function formLivewireEdit(array $params = []);

    public function getFields(array $params = []): Collection;

    public function isRevisionBy(UserContract $user): bool;

    public function related(string $relationship): PanelContract;

    public function relatedName(string $name, ?int $id = null): PanelContract;

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function getBuilder();

    public function getTradMod(): string;

    /**
     * Undocumented function.
     */
    public function filters(): array;

    /**
     * @return int|string|null
     */
    public function optionId(Model $row);

    public function optionLabel(Model $row): string;

    //public function isInternalPage(): bool;

    public function rules(array $params = []): array;

    public function getRules(array $params = []): array;

    public function rulesMessages(): array;

    //--------------------- ACTIONS -------------------

    /**
     * @return mixed
     */
    public function urlContainerAction(string $act, array $params = []);

    /**
     * crea l'oggetto del pannello Container (quello dove passi $rowS).
     */
    public function containerAction(string $act): XotBasePanelAction;
}
