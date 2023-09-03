package wishlist.web;

import javax.validation.Valid;
import lombok.Value;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.dao.EmptyResultDataAccessException;
import org.springframework.http.HttpStatus;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.Errors;
import org.springframework.web.bind.annotation.*;
import wishlist.User;
import wishlist.UserWishMapping;
import wishlist.UserWishMappingId;
import wishlist.Wish;
import wishlist.data.UserWishMappingRepository;
import wishlist.data.WishRepository;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

@Controller
@RequestMapping("/mywishlist")
@Slf4j
public class MyWishlistController {

    private User currentUser;

    private WishRepository wishRepository;

    private UserWishMappingRepository userWishMappingRepository;

    @Autowired
    public MyWishlistController(WishRepository wishRepository, UserWishMappingRepository userWishMappingRepository){
        this.wishRepository = wishRepository;
        this.userWishMappingRepository = userWishMappingRepository;
    }

    @ModelAttribute(name = "wish")
    public Wish wish() { return new Wish(); }

    @ModelAttribute
    public void getWishes(Model model) {
        currentUser = (User) SecurityContextHolder.getContext().getAuthentication().getPrincipal();
        List<UserWishMapping> userWishMappings = userWishMappingRepository.findAllByUser(currentUser);

        List<Wish> allWishes = new ArrayList<>();
        for (UserWishMapping userWishMapping : userWishMappings){
            allWishes.add(userWishMapping.getWish());
        }

        model.addAttribute("wishes", allWishes);
    }

//    @ModelAttribute
//    public void getUsername(Model model) {
//        currentUser = (User) SecurityContextHolder.getContext().getAuthentication().getPrincipal();
//        model.addAttribute("username", currentUser.getUsername());
//    }

    @GetMapping
    public String showMyWishlist() {return "mywishlist"; }

    @GetMapping("/add")
    public String showFormToAddItem() { return "additem"; }

    @PostMapping
    public String addItem(@Valid Wish wish, Errors errors) {
        if (errors.hasErrors()){
            System.out.println(errors);
            return "redirect:/mywishlist/add";
        }

        wish.setReservedBy(null);
        Wish savedWish = wishRepository.save(wish);
        currentUser = (User) SecurityContextHolder.getContext().getAuthentication().getPrincipal();
        System.out.println(wish.getId());

        UserWishMappingId id = new UserWishMappingId();
        id.setUserId(currentUser.getId());
        id.setWishId(savedWish.getId());

        UserWishMapping userWishMapping = new UserWishMapping(currentUser, savedWish);
        userWishMapping.setId(id);
        userWishMappingRepository.save(userWishMapping);

        return "redirect:/mywishlist";
    }

    @GetMapping("/wish-delete/{wishId}")
    public String deleteWish(@PathVariable("wishId") int id) {
        try{
            wishRepository.deleteById(id);
            System.out.println("done");
        } catch (Exception e) {
            System.out.println("xyz");
        }

        return "redirect:/mywishlist";
    }

    @GetMapping("/wish-edit/{wishId}")
    public String editWishForm(@PathVariable("wishId") int id, Model model){
        Optional<Wish> wishForUpdate = wishRepository.findById(id);
        model.addAttribute("wish", wishForUpdate);
        return "editWish";
    }

    @PostMapping("/wish-edit")
    public String editWish(@ModelAttribute("wish") Wish editedWish){
        Optional<Wish> oldWish = wishRepository.findById(editedWish.getId());
        System.out.println(editedWish.getId());

        if (oldWish.isPresent()) {
            Wish wishToUpdate = oldWish.get();
            List<UserWishMapping> currentUserWishMappings = editedWish.getUserWishMappings();

            wishToUpdate.setName(editedWish.getName());
            wishToUpdate.setCount(editedWish.getCount());
            wishToUpdate.setFordate(editedWish.getFordate());
            wishToUpdate.setUserWishMappings(currentUserWishMappings);

            wishRepository.save(wishToUpdate);
        }

        return "redirect:/mywishlist";
    }
}
